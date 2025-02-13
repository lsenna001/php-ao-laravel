<?php

namespace App\Library;

use DI\Container;
use Dotenv\Dotenv;
use DI\ContainerBuilder;
use Spatie\Ignition\Ignition;

class App
{

    // Container de Injeção de Dependências
    public readonly Container $container;

    public static function create(): App
    {
        return new self;
    }

    /**
     * Inicia o app com traceback de errors
     * @return App
     */
    public function withErrorPage(): App
    {
        // Inicia o Ignition, library de backtrace de erros
        Ignition::make()
            ->shouldDisplayException(env('ENV') === 'development')
            ->setTheme('dark')
            ->register();

        return $this;
    }

    /**
     * Inicia a injeção de dependência
     * @return App
     */
    public function withContainer(): App
    {
        $builder = new ContainerBuilder();
        $this->container = $builder->build();

        return $this;
    }

    /**
     * Inicia as variáveis de ambiente
     * @return App
     */
    public function withEnvironmentVariables(): App
    {
        // Inicia o Dotenv, library de carregamento de variáveis de ambiente
        $dotenv = Dotenv::createImmutable(BASEPATH);
        $dotenv->load();

        return $this;
    }
}
