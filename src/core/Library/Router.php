<?php

namespace Core\Library;

class Router
{
    // Array de rotas
    protected array $routes = [];
    protected ?string $controller = null;
    protected string $action;

    /**
     * Adiciona uma nova rota no array de rotas.
     *
     * @param string $method Método HTTP que será utilizado (e.g., 'GET', 'POST').
     * @param string $uri A URI procurada.
     * @param array $route Mapeamento de Controller
     */
    public function add(
        string $method,
        string $uri,
        array $route
    ) {
        $this->routes[$method][$uri] = $route;
    }

    /**
     * Executa as rotas
     */
    public function execute()
    {
        foreach ($this->routes as $request => $routes) {
            if ($request === REQUEST_METHOD) return $this->handleUri($routes);
        }
    }

    /**
     * Manipula a URI recebida e retorna o Controller correspondente
     * @param array $routes Rotas cadastradas
     */
    private function handleUri(array $routes)
    {
        foreach ($routes as $uri => $route) {
            if ($uri === $_SERVER['REQUEST_URI']) {
                [$this->controller, $this->action] = $route;
                break;
            }

            $pattern = str_replace('/', '\/', trim($uri, '/'));

            if ($uri !== '/' && preg_match("/^$pattern$/", trim(REQUEST_URI, '/'), $matches)) {
                [$this->controller, $this->action] = $route;
                unset($matches[0]);
                break;
            }
        }

        if ($this->controller) {
            return $this->handleController();
        }

        return $this->handleNotFound();
    }

    /**
     * Controller existente
     */
    private function handleController() {
        dump('Found Controller');
    }

    /**
     * Controller não existente
     */
    private function handleNotFound() {
        dump('404');
    }
}
