<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Models\AuthToken;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->registerMiddleware(new AuthMiddleware(['logout', 'accountView', 'account', 'deleteAccountView', 'deleteAccount'], ['register', 'login']));
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
        if (\is_null($this->app()->session->get('user')) && !empty($_COOKIE['rememberMe'])) {
            $rememberMe = \explode(':', $_COOKIE['rememberMe']);
            $authToken = new AuthToken();
            if ($authToken->checkAuthToken($rememberMe)) {
                $userId = $authToken->getUserId();

                $user = new User('account');
                $user->login($userId);

                $this->app()->session->set('user', $user->record);
                $this->app()->session->set('publicPage', 1);
                $this->app()->session->set('privatePage', 1);

                return $response->redirect(Application::$base . "/gallery");
            }
        }

        if ($request->isPost()) {
            $user = new User('login');
            $user->loadModelData($request->getBody());
            if ($user->validateModelData(['email', 'password']) && $user->login()) {
                if ($user->rememberMe) {
                    $authToken = new AuthToken(intval($user->record['id']));
                    $authToken->insert();
                    $authToken->setCookie();
                }

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

                if (!empty($_COOKIE['rememberMe'])) {
                    AuthToken::deleteCookie();
                }

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

    public function accountView($request, $response)
    {
        if ($request->isPost()) {
            $user = new User('account');
            $user->getUser(intval($this->app()->session->get('user')['id']));

            return $response->json([
                'page' => 'account',
                'view' => $this->renderView("Auth/account", $user->record),
            ]);
        }
    }

    public function account($request, $response)
    {
        if ($request->isPost()) {
            $user = new User('account');
            $user->loadModelData($request->getBody());
            if ($user->validateModelData() && $user->updateUser()) {
                return $response->json([
                    'userName' => $user->record['name'],
                    'msg' => 'Account info updated successfully',
                ]);
            }

            return $response->json(['errors' => $user->errors]);
        }
    }

    public function deleteAccountView($request, $response)
    {
        if ($request->isPost()) {
            return $response->json([
                'viewDelAcc' => $this->renderView("Auth/deleteAccount", ['action' => Application::$base . '/deleteAccount']),
            ]);
        }
    }

    public function deleteAccount($request, $response)
    {
        if ($request->isPost()) {
            $user = new User('account');
            $isDeleted = $user->deleteUser(intval($this->app()->session->get('user')['id']));

            return $response->json([
                'isDeleted' => $isDeleted,
                'home' => Application::$base . "/",
            ]);
        }
    }
}
