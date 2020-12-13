<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->registerMiddleware(new AuthMiddleware(['logout'], ['register', 'login']));
    }

    public function register($request, $response)
    {
        if ($request->isPost()) {
            $user = new User('register');
            $user->loadModelData($request->getBody());

            if ($user->validateModelData() && $user->insert()) {
                return $response->json([
                    'msg' => 'Thanks for registering',
                    'location' => Application::$base . "/login",
                ]);
            }

            return $response->json(['errors' => $user->errors]);
        }

        return $this->render("Auth/register");
    }

    public function login($request, $response)
    {
        if ($request->isPost()) {
            $user = new User('login');
            $user->loadModelData($request->getBody());
            if ($user->validateModelData(['email', 'password']) && $user->login()) {
                $this->app()->session->set('user', $user->record);
                $this->app()->session->set('publicPage', 1);
                $this->app()->session->set('privatePage', 1);

                return $response->json([
                    'msg' => 'Thanks for login',
                    'location' => Application::$base . "/gallery",
                ]);
            }

            return $response->json(['errors' => $user->errors]);
        }

        return $this->render("Auth/login");
    }

    public function logout($request, $response)
    {
        if ($request->isPost()) {
            $logout = $request->getBody()['logout'] === 'true' ? true : false;

            if ($logout) {
                $this->app()->session->remove('user');
                $this->app()->session->remove('publicPage');
                $this->app()->session->remove('privatePage');
                return $response->json([
                    'home' => Application::$base . "/",
                ]);
            }

            return $response->json([
                'gallery' => Application::$base . "/gallery",
            ]);
        }

        return $this->render("Auth/logout");
    }
}
