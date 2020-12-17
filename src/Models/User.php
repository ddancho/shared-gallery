<?php

namespace App\Models;

use App\Core\Application;
use App\Core\Model;

class User extends Model
{
    protected $name = '';
    protected $email = '';
    protected $password = '';
    protected $confirm = '';

    public $record;

    private $id = null;
    private $rule = '';
    private $rules = [];
    private $ruleOverride = [
        'register' => [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, self::RULE_UNIQUE],
        ],
        'login' => [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
        ],
        'account' => [
            'name' => [],
            'email' => [],
            'password' => [],
            'confirm' => [],
        ],
    ];

    public function __construct($rule)
    {
        $rules = $this->ruleOverride[$rule];
        $this->setRules($rules);
        $this->rule = $rule;
    }

    public function login()
    {
        $this->record = $this->get('email', \PDO::PARAM_STR, $this->email, true);
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

    public function getUser($id)
    {
        $record = parent::get('id', \PDO::PARAM_INT, $id);
        $record['action'] = Application::$base . '/account';
        unset($record['password']);

        return $record;
    }

    public function loadModelData($data)
    {
        if ($this->rule === 'account') {
            $this->rules['name'] = [self::RULE_REQUIRED];

            if (!empty($data['email'])) {
                $this->id = intval(Application::$app->session->get('user')['id']);
                $user = parent::get('id', \PDO::PARAM_INT, $this->id);

                if (strcmp($data['email'], $user['email']) === 0) {
                    unset($data['email']);
                    unset($this->rules['email']);
                } else {
                    $this->rules['email'] = [self::RULE_REQUIRED, self::RULE_EMAIL, self::RULE_UNIQUE];
                }
            }

            if (!empty($data['password'])) {
                $this->rules['password'] = [self::RULE_REQUIRED];
                $this->rules['confirm'] = [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']];
            } else {
                unset($data['password']);
                unset($data['confirm']);
                unset($this->rules['password']);
                unset($this->rules['confirm']);
            }
        }

        parent::loadModelData($data);
    }

    public function updateUser()
    {
        $params = [];

        if (!empty($this->name)) {
            $params['name'] = [
                "value" => $this->name,
                "type" => \PDO::PARAM_STR,
            ];
        }

        if (!empty($this->email)) {
            $params['email'] = [
                "value" => $this->email,
                "type" => \PDO::PARAM_STR,
            ];
        }

        if (!empty($this->password)) {
            $params['password'] = [
                "value" => \password_hash($this->password, PASSWORD_BCRYPT),
                "type" => \PDO::PARAM_STR,
            ];
        }

        if (!empty($params)) {
            $params['id'] = [
                "value" => $this->id,
                "type" => \PDO::PARAM_INT,
            ];

            $params['updated_at'] = [
                "value" => date('Y-m-d H:i:s'),
                "type" => \PDO::PARAM_STR,
            ];

            $response = parent::update($params);

            if ($response) {
                $this->record = parent::get('id', \PDO::PARAM_INT, $this->id);
                Application::$app->session->remove('user');
                Application::$app->session->set('user', $this->record);
            }

            return $response;
        }

        return false;
    }

    private function setRules($rules)
    {
        $this->rules = [
            'name' => [self::RULE_REQUIRED],
            'email' => [],
            'password' => [self::RULE_REQUIRED],
            'confirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];

        foreach ($rules as $key => $params) {
            $this->rules[$key] = $params;
        }
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
        return $this->rules;
    }
}
