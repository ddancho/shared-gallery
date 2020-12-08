<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->registerMiddleware(new AuthMiddleware(['index'], []));
    }

    public function index()
    {
        return $this->render("Home/index");
    }
}
