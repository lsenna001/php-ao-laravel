<?php

use App\Library\App;
use Core\Templates\Plates;

// Inicia o App
$app = App::create()
    ->withEnvironmentVariables()
    ->withTemplateEngine(Plates::class)
    ->withErrorPage()
    ->withContainer();
