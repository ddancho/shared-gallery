<?php

use App\Controllers\HomeController;
use App\Core\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$config = [
    'assets' => "http://localhost/shared-gallery/src/assets",
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [HomeController::class, 'index']);
