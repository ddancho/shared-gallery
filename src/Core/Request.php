<?php

namespace App\Core;

class Request
{
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
        $path = $_SERVER['PATH_INFO'] ?? ($_SERVER['REDIRECT_PATH_INFO'] ?? '/');
        return \filter_var($path, FILTER_SANITIZE_URL);
    }

    public function getMethod()
    {
        return \strtolower($_SERVER['REQUEST_METHOD']);
    }
}
