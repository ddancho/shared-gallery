<?php

namespace App\Core\Middlewares;

use App\Core\Application;
use App\Core\Exception\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    private $actions = [];
    private $requirement = null;

    public function __construct($actions = [], $requirement = null)
    {
        $this->actions = $actions;
        $user = Application::$app->session->get('user');

        if ($requirement === null) {
            $this->requirement = $user === null ? true : false;
        } else {
            $this->requirement = $user !== null ? true : false;
        }

    }

    public function execute()
    {
        if ($this->requirement) {
            if (empty($this->actions) || \in_array(Application::$app->router->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}
