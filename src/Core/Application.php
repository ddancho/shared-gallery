<?php

namespace App\Core;

class Application
{
    public static $ROOT_DIR;
    public static $app;
    public static $assets;
    public static $js;
    public static $base;

    public $request;
    public $response;
    public $router;
    public $session;
    public $database;

    public function __construct($rootDir, $config)
    {
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;

        self::$assets = $config['assets'];
        self::$js = $config['js'];
        self::$base = $config['base'];

        $this->database = new Database($config['db']);
        $this->session = new Session();
        $this->request = new Request($config['base']);
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
