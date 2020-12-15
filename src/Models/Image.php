<?php

namespace App\Models;

use App\Core\Application;
use App\Core\Model;

class Image extends Model
{
    protected $user_id = null;
    protected $image_name = '';
    protected $image_ext = '';
    protected $image_comment = '';
    protected $image_status = null;
    protected $image_data = '';

    public $file = [];
    public const IMAGE_PUBLIC = 0;
    public const IMAGE_PRIVATE = 1;
    private const IMAGE_SCALE_WIDTH = 500;

    public function __construct($params = [])
    {
        if (!empty($params)) {
            $this->user_id = intval($params['user']['id']);
            $this->image_status = $params['body']['visibility'] === 'public' ? self::IMAGE_PUBLIC : self::IMAGE_PRIVATE;
            $this->image_comment = $params['body']['comment'] ?? '';
            $this->file = $params['file'];
        }
    }

    public function insert()
    {
        $this->image_name = \explode('.', $this->file['name'])[0];
        $this->image_ext = \explode('/', \strtolower($this->file['type']))[1];
        $this->image_data = \base64_encode(\file_get_contents(\addslashes($this->file['tmp_name'])));

        return parent::insert();
    }

    public function getAllPublic($options = [])
    {
        $orderBy = $options['sortBy'] === 'date' ? 'created_at' : 'uploader';
        $direction = $options['direction'] === 'asc' ? 'asc' : 'desc';

        $page = $options['page'] === 'null' ? null : intval($options['page']);

        $page = $this->managePage($page, 'publicPage');
        $imagesPerPage = intval($options['ipp']);
        $currentPage = ($page - 1) * $imagesPerPage;

        $params = [
            'query' => "SELECT *, (SELECT name FROM users u WHERE i.user_id = u.id) AS uploader FROM images i WHERE i.image_status = :attr ORDER BY $orderBy $direction LIMIT :currentPage, :imagesPerPage",
            'attr' => [
                'value' => Image::IMAGE_PUBLIC,
                'type' => \PDO::PARAM_INT,
            ],
            'currentPage' => [
                'value' => $currentPage,
                'type' => \PDO::PARAM_INT,
            ],
            'imagesPerPage' => [
                'value' => $imagesPerPage,
                'type' => \PDO::PARAM_INT,
            ],
        ];

        $records = parent::getAll($params);

        foreach ($records as $key => $record) {
            $img = $this->scaleImage($record['image_data'], $record['image_ext'], Image::IMAGE_SCALE_WIDTH);
            $records[$key]['src'] = 'data:image/' . $record['image_ext'] . ';base64,' . $img;
            unset($records[$key]['image_ext']);
            unset($records[$key]['image_data']);
        }

        return $records;
    }

    public function getAllPrivate($user, $options = [])
    {
        $orderBy = 'created_at';
        $direction = $options['direction'] === 'asc' ? 'asc' : 'desc';

        $page = $options['page'] === 'null' ? null : intval($options['page']);

        $page = $this->managePage($page, 'privatePage');
        $imagesPerPage = intval($options['ipp']);
        $currentPage = ($page - 1) * $imagesPerPage;

        $params = [
            'query' => "SELECT * FROM images i WHERE i.user_id = :attr ORDER BY $orderBy $direction LIMIT :currentPage, :imagesPerPage",
            'attr' => [
                'value' => $user['id'],
                'type' => \PDO::PARAM_STR,
            ],
            'currentPage' => [
                'value' => $currentPage,
                'type' => \PDO::PARAM_INT,
            ],
            'imagesPerPage' => [
                'value' => $imagesPerPage,
                'type' => \PDO::PARAM_INT,
            ],
        ];

        $records = parent::getAll($params);

        foreach ($records as $key => $record) {
            $img = $this->scaleImage($record['image_data'], $record['image_ext'], Image::IMAGE_SCALE_WIDTH);
            $records[$key]['class'] = intval($record['image_status']) === Image::IMAGE_PUBLIC ? 'container' : 'container__private';
            $records[$key]['src'] = 'data:image/' . $record['image_ext'] . ';base64,' . $img;
            unset($records[$key]['image_ext']);
            unset($records[$key]['image_data']);
        }

        return $records;
    }

    public function getImage($id, $info = false)
    {
        $record = parent::get('id', \PDO::PARAM_INT, $id);

        if ($info) {
            $record['action'] = Application::$base . '/updateImage';            
            unset($record['image_data']);
            return $record;
        }

        return 'data:image/' . $record['image_ext'] . ';base64,' . $record['image_data'];
    }

    public function getImagesCount($options)
    {
        $column = $options['column'];

        $params = [
            'query' => "SELECT COUNT(*) FROM images WHERE " . $column . " = :attr",
            'attr' => [
                'value' => $options['value'],
                'type' => $options['type'],
            ],
        ];

        return intval(parent::getCount($params));
    }

    public function updateImage($options)
    {
        $params = [
            "id" => [
                "value" => \intval($options['id']),
                "type" => \PDO::PARAM_INT,
            ],
            "image_name" => [
                "value" => $options['image_name'],
                "type" => \PDO::PARAM_STR,
            ],
            "image_comment" => [
                "value" => $options['image_comment'],
                "type" => \PDO::PARAM_STR,
            ],
            "image_status" => [
                "value" => $options['visibility'] === 'public' ? Image::IMAGE_PUBLIC : Image::IMAGE_PRIVATE,
                "type" => \PDO::PARAM_INT,
            ],
            "updated_at" => [
                "value" => date('Y-m-d H:i:s'),
                "type" => \PDO::PARAM_STR,
            ],
        ];

        return parent::update($params);
    }

    public function rules()
    {
        return [
            'file' => [self::RULE_IMAGE_SIZE_ZERO, self::RULE_IMAGE_SIZE_LIMIT, self::RULE_IMAGE_TYPE, self::RULE_IMAGE_UPLOAD_ERROR],
        ];
    }

    public function table()
    {
        return 'images';
    }

    public function columns()
    {
        return [
            'user_id' => \PDO::PARAM_INT,
            'image_name' => \PDO::PARAM_STR,
            'image_ext' => \PDO::PARAM_STR,
            'image_comment' => \PDO::PARAM_STR,
            'image_status' => \PDO::PARAM_INT,
            'image_data' => \PDO::PARAM_LOB,
        ];
    }

    private function managePage($page, $key, $defaults = ['publicPage', 'privatePage'])
    {
        $current = Application::$app->session->get($key);

        if ($page === 0) {
            $current = 1;
            foreach ($defaults as $param) {
                Application::$app->session->set($param, $current);
            }
        } else if ($page === 1) {
            $current += 1;
            Application::$app->session->set($key, $current);
        } else if ($page === -1) {
            $current -= 1;
            Application::$app->session->set($key, $current);
        }

        return $current;
    }

    private function scaleImage($imageData, $imageType, $width)
    {
        $image = \imagescale(\imagecreatefromstring(\base64_decode($imageData)), $width);

        \ob_start();
        $imageType === 'png' ? \imagepng($image) : \imagejpeg($image);
        $data = ob_get_clean();

        return \base64_encode($data);
    }
}
