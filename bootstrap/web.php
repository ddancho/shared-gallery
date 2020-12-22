<?php

use App\Controllers\AuthController;
use App\Controllers\GalleryController;
use App\Controllers\HomeController;
use App\Controllers\ImageController;
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
$app->router->post('/publicGallery', [GalleryController::class, 'publicGallery']);
$app->router->post('/privateGallery', [GalleryController::class, 'privateGallery']);

$app->router->post('/accountView', [AuthController::class, 'accountView']);
$app->router->post('/account', [AuthController::class, 'account']);
$app->router->post('/deleteAccountView', [AuthController::class, 'deleteAccountView']);
$app->router->post('/deleteAccount', [AuthController::class, 'deleteAccount']);

$app->router->post('/uploadImageView', [ImageController::class, 'uploadImageView']);
$app->router->post('/uploadImage', [ImageController::class, 'uploadImage']);
$app->router->post('/getImage', [ImageController::class, 'getImage']);
$app->router->post('/updateImageView', [ImageController::class, 'updateImageView']);
$app->router->post('/updateImage', [ImageController::class, 'updateImage']);
$app->router->post('/deleteImageView', [ImageController::class, 'deleteImageView']);
$app->router->post('/deleteImage', [ImageController::class, 'deleteImage']);
