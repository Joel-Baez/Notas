<?php

namespace App\Controllers;

class BaseController
{
    protected function render(string $view, array $params = []): void
    {
        extract($params);
        $viewFile = __DIR__ . '/../views/' . $view . '.php';
        $layoutFile = __DIR__ . '/../views/layout/main.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View {$view} not found");
        }

        ob_start();
        include $viewFile;
        $content = ob_get_clean();
        include $layoutFile;
    }
}
