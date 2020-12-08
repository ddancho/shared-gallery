<?php

namespace App\Core;

class Controller
{
    public $action;
    public $middlewares = [];

    protected $view;

    protected function __construct()
    {
        $this->view = new View();
    }

    protected function render($view, $params = [])
    {
        return $this->view->render($view, $params);
    }

    protected function renderView($view, $params = [])
    {
        return $this->view->renderView($view, $params);
    }

    protected function app()
    {
        return Application::$app;
    }

    public function registerMiddleware($middleware)
    {
        $this->middlewares[] = $middleware;
    }
}
