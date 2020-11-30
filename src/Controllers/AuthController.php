<?php

namespace App\Controllers;

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
            $user = new User();
            $user->loadModelData($request->getBody());

            if ($user->validateModelData() && $user->insert()) {
                return $response->json(['success' => 'Thanks for registering']);
            }

            return $response->json(['errors' => $user->errors]);
        }

        return $this->render("Auth/register");
    }
}
