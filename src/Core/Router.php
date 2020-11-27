<?php

namespace App\Core;

use App\Core\Exception\NotFoundException;

class Router
{
    private $routes = [];
    private $request;
    private $response;
    private $controller;
    private $action;

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
            $this->response->setStatusCode(404);
            throw new NotFoundException();
        }

        if (\is_string($callback)) {
            // TO DO
            // just view
        }

        if (\is_array($callback) && class_exists($callback[0]) && \method_exists($callback[0], $callback[1])) {
            $controller = new $callback[0];
            $action = $callback[1];
            return \call_user_func([$controller, $action], $this->request, $this->response);
        }

        $this->response->setStatusCode(404);
        throw new NotFoundException();
    }

}
