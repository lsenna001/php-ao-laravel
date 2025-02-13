<?php

namespace Core\Library;

use League\Plates\Engine;
use Core\Exceptions\ViewNotFoundException;

class Layout
{
    /**
     * Renderiza uma view
     * @param string $view Nome da View
     * @param array $data Dados da View
     */
    public static function render(string $view, array $data = [], string $view_path = VIEWPATH)
    {
        if (!file_exists($view_path . "/{$view}.php")) {
            throw new ViewNotFoundException("View {$view} not found");
        }
        $templates = new Engine($view_path);

        echo $templates->render($view, $data);
    }
}
