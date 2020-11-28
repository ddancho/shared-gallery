<?php

use App\Core\Migration;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'dsn' => $_ENV['DB_DSN'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
];

$migration = new Migration($config, __DIR__);
$migration->applyMigrations();
