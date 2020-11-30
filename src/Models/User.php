<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $name = '';
    protected $email = '';
    protected $password = '';
    protected $confirm = '';

    public function table()
    {
        return 'users';
    }

    public function columns()
    {
        return [
            'name' => \PDO::PARAM_STR,
            'email' => \PDO::PARAM_STR,
            'password' => \PDO::PARAM_STR,
        ];
    }

    public function rules()
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, self::RULE_UNIQUE],
            'password' => [self::RULE_REQUIRED],
            'confirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }
}
