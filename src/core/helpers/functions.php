<?php

use Core\Library\Container;
use Core\Library\Layout;
use Core\Library\Response;

/**
 * Renderiza uma view
 * @param string $view Nome da View
 * @param array $data Dados da View
 * @param string $view_path Caminho da View
 */
function view(string $view, array $data = [], string $view_path = VIEWPATH): Response
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

/**
 * Define uma resposta HTTP.
 * @param string $content Conteúdo da Resposta
 * @param int $status Status HTTP
 * @param array $headers Cabeçalhos HTTP
 * @return Response Objeto Response
 */
function response(string $content = '', int $status = 200, array $headers = []): Response
{
    return new Response($content, $status, $headers);
}
