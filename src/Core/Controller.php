<?php

namespace App\Core;

class Controller
{
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
}
