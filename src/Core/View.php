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

    private function renderView($view, $params)
    {
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $$key = $value;
            }
        }

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
