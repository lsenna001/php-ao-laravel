<?php

use Core\Library\Container;
use Core\Library\Layout;

/**
 * Renderiza uma view
 * @param string $view Nome da View
 * @param array $data Dados da View
 * @param string $view_path Caminho da View
 */
function view(string $view, array $data = [], string $view_path = VIEWPATH)
{
    return Layout::render($view, $data, $view_path);
}

/**
 * Executa o bind no Service Container do App
 * @param string $key
 * @param mixed $value
 */
function bind(string $key, mixed $value)
{
    Container::bind($key, $value);
}

/**
 * Resolve o bind no Service Container do App
 * @param string $key
 */
function resolve(string $key)
{
    return Container::resolve($key);
}