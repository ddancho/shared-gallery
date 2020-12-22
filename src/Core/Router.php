<?php

namespace App\Core;

use App\Core\Exception\NotFoundException;

class Router
{
    private $routes = [];
    private $request;
    private $response;

    public $controller;

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolveRoute()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback) {
            throw new NotFoundException();
        }

        if (\is_array($callback) && class_exists($callback[0]) && \method_exists($callback[0], $callback[1])) {
            $this->controller = new $callback[0];
            $this->controller->action = $callback[1];

            foreach ($this->controller->middlewares as $middleware) {
                $middleware->execute();
            }

            return \call_user_func([$this->controller, $this->controller->action], $this->request, $this->response);
        }

        throw new NotFoundException();
    }
}
