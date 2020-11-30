<?php

namespace App\Core;

class Response
{
    public function setStatusCode($code)
    {
        \http_response_code($code);
    }

    public function redirect($url)
    {
        \header('Location: ' . $url);
    }

    public function json($response)
    {
        header('Content-Type: application/json');
        return \json_encode($response);
    }
}
