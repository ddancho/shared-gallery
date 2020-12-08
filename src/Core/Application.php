<?php

namespace App\Core;

class Application
{
    public static $ROOT_DIR;
    public static $app;
    public static $assets;
    public static $js;
    public static $base;

    public $router;
    public $session;
    public $database;

    private $request;
    private $response;
    private $view;
    private $errors = [403, 404];

    public function __construct($rootDir, $config)
    {
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;

        self::$assets = $config['assets'];
        self::$js = $config['js'];
        self::$base = $config['base'];

        $this->database = new Database($config['db']);
        $this->session = new Session();

        $this->view = new View();
        $this->request = new Request($config['base']);
        $this->response = new Response();

        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        try {
            echo $this->router->resolveRoute();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView("Errors/_error", ['error' => $e->getMessage()]);
        }
    }
}
