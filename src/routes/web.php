<?php

use Core\Library\Router;
use App\Controllers\{HomeController, ProductController, LoginController};

// Inicia o Router
$router = new Router($app->container);

// Define as rotas
$router->add('GET', '/', [HomeController::class, 'index']);
$router->add('GET', '/product/([a-z\-]+)', [ProductController::class, 'show']);
$router->add('GET', '/product/([a-z\-]+)/category/([a-z]+)', [ProductController::class, 'show']);
$router->add('GET', '/login', [LoginController::class, 'index']);
$router->add('POST', '/login', [LoginController::class, 'store']);
// Executa as rotas
$router->execute();
