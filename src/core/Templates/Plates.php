<?php

namespace Core\Templates;

use Core\Interfaces\TemplateInterface;
use League\Plates\Engine;

class Plates implements TemplateInterface
{

    public function render(string $view, array $data = [], string $viewPath = VIEWPATH)
    {
        $templates = new Engine($viewPath . '/plates');

        echo $templates->render($view, $data);
    }
}
