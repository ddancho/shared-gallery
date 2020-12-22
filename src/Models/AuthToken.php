<?php

namespace App\Models;

use App\Core\Model;

class AuthToken extends Model
{
    const TIME_EXPIRED = 7 * 24 * 60 * 60;
    protected $selector = '';
    protected $authenticator = '';
    protected $token = '';
    protected $user_id = null;
    protected $expires = '';

    public function __construct($userId = null)
    {
        if ($userId) {
            $this->selector = \base64_encode(\random_bytes(9));
            $this->authenticator = \random_bytes(33);
            $this->token = \hash('sha256', $this->authenticator);
            $this->user_id = $userId;
            $this->expires = \date("Y-m-d H:i:s", time() + self::TIME_EXPIRED);
        }
    }

    public function insert()
    {
        return parent::insert();
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function checkAuthToken($rememberMe)
    {
        $selector = $rememberMe[0] ?? '';
        $authenticator = $rememberMe[1] ?? '';

        $record = parent::get('selector', \PDO::PARAM_STR, $selector);
        if (!empty($record)) {
            if (\hash_equals($record['token'], hash('sha256', base64_decode($authenticator)))) {
                $this->updateAuthToken($record);
                return true;
            }
        }

        return false;
    }

    public function setCookie($expires = null)
    {
        setcookie(
            "rememberMe",
            $this->selector . ':' . \base64_encode($this->authenticator),
            $expires !== null ? $expires : time() + self::TIME_EXPIRED,
            "/",
            null,
            true,
            true
        );
    }

    public static function deleteCookie()
    {
        unset($_COOKIE['rememberMe']);
        setcookie("rememberMe", "0", time() - 1, "/", null, true, true);
    }

    private function updateAuthToken($record)
    {
        $this->selector = \base64_encode(\random_bytes(9));
        $this->authenticator = \random_bytes(33);
        $this->token = \hash('sha256', $this->authenticator);
        $this->user_id = intval($record['user_id']);
        $this->expires = $record['expires'];

        $params = [
            'id' => [
                "value" => $record['id'],
                "type" => \PDO::PARAM_INT,
            ],
            'selector' => [
                "value" => $this->selector,
                "type" => \PDO::PARAM_STR,
            ],
            'token' => [
                "value" => $this->token,
                "type" => \PDO::PARAM_STR,
            ],
            'user_id' => [
                "value" => $this->user_id,
                "type" => \PDO::PARAM_INT,
            ],
            'expires' => [
                "value" => $this->expires,
                "type" => \PDO::PARAM_STR,
            ],
        ];

        $response = parent::update($params);

        if ($response) {
            $expires = \strtotime($record['expires']);
            $this->setCookie($expires);
        }

        return $response;
    }

    public function table()
    {
        return 'auth_tokens';
    }

    public function columns()
    {
        return [
            'selector' => \PDO::PARAM_STR_CHAR,
            'token' => \PDO::PARAM_STR_CHAR,
            'user_id' => \PDO::PARAM_INT,
            'expires' => \PDO::PARAM_STR,
        ];
    }

    public function rules()
    {}
}
