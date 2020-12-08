<?php

namespace App\Models;

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
        $params = [
            'query' => "SELECT *, (SELECT name FROM users u WHERE i.user_id = u.id) AS uploader FROM images i WHERE i.image_status = :attr",
            'value' => Image::IMAGE_PUBLIC,
            'type' => \PDO::PARAM_STR,
        ];

        $records = parent::getAll($params);

        foreach ($records as $key => $record) {
            $records[$key]['src'] = 'data:image/' . $record['image_ext'] . ';base64,' . $record['image_data'];
            unset($records[$key]['image_ext']);
            unset($records[$key]['image_data']);
        }

        return $records;
    }

    public function getAllPrivate($options = [])
    {
        $params = [
            'query' => "SELECT * FROM images i WHERE i.user_id = :attr",
            'value' => $options['user']['id'],
            'type' => \PDO::PARAM_STR,
        ];

        $records = parent::getAll($params);

        foreach ($records as $key => $record) {
            $records[$key]['class'] = intval($record['image_status']) === Image::IMAGE_PUBLIC ? 'container' : 'container__private';
            $records[$key]['src'] = 'data:image/' . $record['image_ext'] . ';base64,' . $record['image_data'];
            unset($records[$key]['image_ext']);
            unset($records[$key]['image_data']);
        }

        return $records;
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
}
