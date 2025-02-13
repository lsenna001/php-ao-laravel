<?php

namespace Core\Controllers;

class ErrorController
{
    public function notFound()
    {
        return view("errors/404", [
            'title' => "Page Not Found"
        ], VIEWPATH_CORE);
    }
}
