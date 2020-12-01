<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
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
                return $response->json([
                    'msg' => 'Thanks for login',
                    'location' => Application::$base . "/",
                ]);
            }

            return $response->json(['errors' => $user->errors]);
        }

        return $this->render("Auth/login");
    }
}
