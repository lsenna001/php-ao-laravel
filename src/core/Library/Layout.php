<?php

namespace Core\Library;

use Core\Exceptions\ViewNotFoundException;
use Core\Exceptions\ClassNotFoundException;
use Core\Interfaces\TemplateInterface;

class Layout
{
    /**
     * Renderiza uma view
     * @param string $view Nome da View
     * @param array $data Dados da View
     */
    public static function render(string $view, array $data = [], string $view_path = VIEWPATH)
    {
        $template = resolve('engine');

        if (!class_exists($template)) {
            throw new ClassNotFoundException("Template " . $template::class . " not found.");
        }

        $template = new $template();

        if(!$template instanceof TemplateInterface) {
            throw new ClassNotFoundException("Template " . $template::class . " must be implement TemplateInterface.");
        }

        return $template->render($view, $data, $view_path);
    }
}
