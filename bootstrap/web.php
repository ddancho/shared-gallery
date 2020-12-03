<?php

use App\Controllers\AuthController;
use App\Controllers\GalleryController;
use App\Controllers\HomeController;
use App\Core\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'base' => $_ENV['BASE'],
    'assets' => $_ENV['ASSETS'],
    'js' => $_ENV['JS'],
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [HomeController::class, 'index']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->post('/logout', [AuthController::class, 'logout']);

$app->router->get('/gallery', [GalleryController::class, 'gallery']);
$app->router->post('/gallery', [GalleryController::class, 'gallery']);
$app->router->post('/upload', [GalleryController::class, 'upload']);
