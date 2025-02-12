<?php

use App\Library\App;

// Inicia o App
$app = App::create()
    ->withEnvironmentVariables()
    ->withErrorPage()
    ->withContainer();