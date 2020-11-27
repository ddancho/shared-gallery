<?php

namespace App\Core;

class Application
{
    public static $ROOT_DIR;
    public static $app;
    public static $assets;

    public $request;
    public $response;
    public $router;
    public $session;

    public function __construct($rootDir, $config)
    {
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;
        self::$assets = $config['assets'];

        $this->session = new Session();
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        try {
            echo $this->router->resolveRoute();
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
