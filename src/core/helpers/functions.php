<?php

use Core\Library\Layout;

function view(string $view, array $data = [], string $view_path = VIEWPATH)
{
    return Layout::render($view, $data, $view_path);
}