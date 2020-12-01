<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $name = '';
    protected $email = '';
    protected $password = '';
    protected $confirm = '';

    public $record;

    private $rule;
    private $ruleOverride = [
        'register' => [self::RULE_REQUIRED, self::RULE_EMAIL, self::RULE_UNIQUE],
        'login' => [self::RULE_REQUIRED, self::RULE_EMAIL],
    ];

    public function __construct($rule)
    {
        $this->rule = $this->ruleOverride[$rule];
    }

    public function login()
    {
        $this->record = $this->find('email', \PDO::PARAM_STR, $this->email, true);
        if (!$this->record) {
            $this->addError('email', self::RULE_EMAIL);
            $this->addError('password', self::RULE_PASSWORD);
        }

        if (isset($this->record['password']) && !\password_verify($this->password, $this->record['password'])) {
            $this->addError('password', self::RULE_PASSWORD);
        }

        return empty($this->errors);
    }

    public function insert()
    {
        $this->password = \password_hash($this->password, PASSWORD_BCRYPT);
        return parent::insert();
    }

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
            'email' => $this->rule,
            'password' => [self::RULE_REQUIRED],
            'confirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }
}
