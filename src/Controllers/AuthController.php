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
        $this->registerMiddleware(new AuthMiddleware(['logout', 'account'], ['register', 'login']));
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

    public function account($request, $response)
    {
        $user = new User('account');

        if ($request->isPost()) {
            $user->loadModelData($request->getBody());
            if ($user->validateModelData() && $user->updateUser()) {
                return $response->json([
                    'userName' => $user->record['name'],
                    'msg' => 'Account info updated successfully',
                ]);
            }

            return $response->json(['errors' => $user->errors]);
        }

        $record = $user->getUser(intval($this->app()->session->get('user')['id']));

        return $response->json([
            'page' => 'account',
            'view' => $this->renderView("Auth/account", $record),
        ]);
    }
}
