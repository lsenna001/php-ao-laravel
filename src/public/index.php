<?php

// Inicia a sesão da aplicação
session_start();

// Importa o autoload do composer
require __DIR__ . '/../vendor/autoload.php';

// Importa a inicialização da Aplicação
require '../bootstrap/app.php';

// Importa as rotas web
require '../routes/web.php';

class HomeController
{
    public function index()
    {
        return view('index');
    }
}

$controller = new HomeController;

dd($controller->index());