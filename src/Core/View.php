<?php

namespace App\Core;

class View
{
    private $baseLayout = 'index';

    public function render($view, $params = [])
    {
        $viewContent = $this->renderView($view, $params);
        $layoutContent = $this->renderLayout($this->baseLayout);

        return \str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderView($view, $params)
    {
        \ob_start();

        include_once Application::$ROOT_DIR . "/src/Views/{$view}.php";

        return \ob_get_clean();
    }

    private function renderLayout($layout)
    {
        \ob_start();

        include_once Application::$ROOT_DIR . "/src/Views/Layouts/{$layout}.php";

        return \ob_get_clean();
    }
}
