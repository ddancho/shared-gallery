<?php

namespace App\Core;

class Application
{
    public static $ROOT_DIR;

    public function __construct($rootDir)
    {
        self::$ROOT_DIR = $rootDir;
    }

    public function run()
    {
        echo 'Shared Gallery';
    }
}
