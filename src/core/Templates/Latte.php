<?php

namespace Core\Templates;

use Latte\Engine;
use Core\Interfaces\TemplateInterface;

class Latte implements TemplateInterface
{
    public function render(string $view, array $data = [], string $viewPath = VIEWPATH) 
    {
        $templatePath = $viewPath . '/latte/';
        
        $latte = new Engine;

        $latte->setTempDirectory($templatePath . 'cache');

        $latte->render($templatePath . $view. '.latte', $data);
    }
}
