<?php

namespace Core\Library;

class Response
{
    /**
     * Construtor
     */
    public function __construct(
        private string $content = '',
        private int $status = 200,
        private array $headers = []
    ) {}

    /**
     * Define uma resposta HTTP.
     */
    public function send()
    {
        http_response_code($this->status);

        foreach ($this->headers as $key => $header) {
            header($key . ': ' . $header);
        }

        echo $this->content;
    }

    public function json(array $data)
    {
        // Seta o cabeçalho para JSON
        $this->headers['Content-Type'] = 'application/json';

        // Converte o array para JSON
        $this->content = json_encode($data);

        return $this;
    }
}
