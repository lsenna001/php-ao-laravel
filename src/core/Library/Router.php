<?php

namespace Core\Library;

use DI\Container;
use Core\Controllers\ErrorController;
use Core\Exceptions\ResponseException;
use Core\Exceptions\ControllerNotFoundException;

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
            return $this->handleController();
        }

        return $this->handleNotFound();
    }

    /**
     * Manipula o controller caso exista a rota chamada
     */
    private function handleController()
    {
        // Verifica se o Controller e Action existem
        if (!class_exists($this->controller) || !method_exists($this->controller, $this->action)) {
            throw new ControllerNotFoundException(
                "[$this->controller::$this->action] does not exist"
            );
        }

        // Instancia e Executa o Controller
        $controller = $this->container->get($this->controller);
        $response = $this->container->call([$controller, $this->action], [...$this->parameters]);

        // Prepara a resposta
        $this->handleResponse($response);
    }

    /**
     * Manipula o objeto Response de acordo com o retorno do Controller
     * @param mixed $response Retorno dos Controllers
     */
    private function handleResponse(mixed $response)
    {
        // Converte a resposta de array para json
        if (is_array($response)) {
            $response = response()->json($response);
        }

        // Cria o objeto resposta caso retorno for string
        if (is_string($response)) {
            $response = response($response);
        }

        // Verifica se o retorno é um objeto de Response
        if (!$response instanceof Response) {
            throw new ResponseException("Controller action must return a Response object");
        }

        $response->send();
    }

    /**
     * Rota não existente
     */
    private function handleNotFound()
    {
        (new ErrorController)->notFound();
    }
}
