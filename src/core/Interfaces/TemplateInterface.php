<?php

namespace Core\Interfaces;

interface TemplateInterface
{
    public function render(string $view, array $data = [], string $viewPath = VIEWPATH);
}