<?php

namespace Core\Library;

use Core\Exceptions\ControllerNotFoundException;
use DI\Container;

class Router
{
    // Array de rotas
    protected array $routes = [];

    // Controller
    protected ?string $controller = null;

    // Action
    protected string $action;

    // Parametros
    protected array $parameters = [];

    /**
     * Construtor
     */
    public function __construct(
        private Container $container
    ) {}

    /**
     * Adiciona uma nova rota no array de rotas.
     * @param string $method Método HTTP que será utilizado (e.g., 'GET', 'POST').
     * @param string $uri A URI procurada.
     * @param array $route Mapeamento de Controller
     */
    public function add(string $method, string $uri, array $route)
    {
        $this->routes[$method][$uri] = $route;
    }

    /**
     * Executa as rotas
     */
    public function execute()
    {
        // Passa por todos os métodos HTTP adicionados nas rotas
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
        // Passa por todas as rotas cadastradas
        foreach ($routes as $uri => $route) {

            // Rotas sem parâmetros, caso acha já sai do loop
            if ($uri === $_SERVER['REQUEST_URI']) {
                [$this->controller, $this->action] = $route;
                break;
            }

            // Rotas com parâmetros, monta o pattern
            $pattern = str_replace('/', '\/', trim($uri, '/'));

            // Verifica se a URI atual bate com a URI da rota
            if ($uri !== '/' && preg_match("/^$pattern$/", trim(REQUEST_URI, '/'), $this->parameters)) {
                [$this->controller, $this->action] = $route;
                unset($this->parameters[0]);
                break;
            }
        }

        // Verifica se o Controller foi encontrado
        if ($this->controller) {
            return $this->handleController(
                $this->controller,
                $this->action,
                $this->parameters
            );
        }

        return $this->handleNotFound();
    }

    /**
     * Manipula o controller caso exista a rota chamada
     * @param string $controller Controller
     * @param string $action Action
     * @param array $parameters Parametros
     */
    private function handleController(string $controller, string $action, array $parameters)
    {

        // Verifica se o Controller e Action existem
        if (!class_exists($controller) || !method_exists($controller, $action)) {
            throw new ControllerNotFoundException(
                "[$controller::$action] does not exist"
            );
        }

        // Instancia e Executa o Controller
        $controller = $this->container->get($controller);
        $this->container->call([$controller, $action], [...$parameters]);
    }

    /**
     * Rota não existente
     */
    private function handleNotFound()
    {
        dump('404');
    }
}
