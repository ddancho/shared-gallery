<?php

namespace App\Core\Middlewares;

use App\Core\Application;

class RedirectMiddleware extends BaseMiddleware
{
    private $processors = [];

    public function __construct()
    {
        $requirement = false;
        $redirect = [];

        $user = Application::$app->session->get('user');

        if ($user === null) {
            $requirement = true;
            $redirect = [
                'location' => Application::$base . "/login",
            ];
        }

        $this->processors[] = [
            $requirement => $redirect,
        ];
    }

    public function execute()
    {
        foreach ($this->processors as $processor) {
            foreach ($processor as $requirement => $redirect) {
                if ($requirement) {
                    \header('Location: ' . $redirect['location']);
                }
            }
        }
    }
}
