<?php

namespace App\Core;

class Application
{
    public static $ROOT_DIR;
    public $request;
    public $response;
    public $router;

    public function __construct($rootDir)
    {
        self::$ROOT_DIR = $rootDir;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        try {
            $this->router->resolveRoute();
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
