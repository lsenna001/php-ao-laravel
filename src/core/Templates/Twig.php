<?php

namespace Core\Templates;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Core\Interfaces\TemplateInterface;

class Twig implements TemplateInterface
{
    public function render(string $view, array $data = [], string $viewPath = VIEWPATH)
    {
        $loader = new FilesystemLoader($viewPath . '/twig');
        $twig = new Environment($loader, [
            'cache' => $viewPath . '/twig/cache',
        ]);

        echo $twig->render($view . '.html', $data);
    }

}
