<?php

namespace App\Core;

class Request
{
    private $base;

    public function __construct($base)
    {
        $this->base = $base;
    }

    public function isGet()
    {
        return $this->getMethod() === 'get';
    }

    public function isPost()
    {
        return $this->getMethod() === 'post';
    }

    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '';
        $path = \explode($this->base, $path);
        return \filter_var($path[1], FILTER_SANITIZE_URL);
    }

    public function getMethod()
    {
        return \strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBody()
    {
        $body = [];

        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $body[$key] = \filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $body[$key] = \filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}
