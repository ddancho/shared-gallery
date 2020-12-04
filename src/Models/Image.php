<?php

namespace App\Models;

use App\Core\Model;

class Image extends Model
{

    protected $user_id = null;
    protected $image_name = '';
    protected $image_ext = '';
    protected $image_status = null;
    protected $image_data = '';

    public $file = [];

    public function __construct($user, $status, $file)
    {
        $this->user_id = intval($user['id']);
        $this->image_status = $status;
        $this->file = $file;
    }

    public function insert()
    {
        $this->image_name = \explode('.', $this->file['name'])[0];
        $this->image_ext = \explode('/', \strtolower($this->file['type']))[1];
        $this->image_data = \base64_encode(\file_get_contents(\addslashes($this->file['tmp_name'])));

        return parent::insert();
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
            'image_status' => \PDO::PARAM_INT,
            'image_data' => \PDO::PARAM_LOB,
        ];
    }
}
