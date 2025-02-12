<?php

namespace App\Controllers;

use App\Library\Email;

class ProductController
{
    public function index() {}
    public function show(string $product, Email $email)
    {
        dd($product, $email);
    }
}
