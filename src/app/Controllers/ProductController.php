<?php

namespace App\Controllers;

class ProductController
{
    public function index() {}
    public function show(string $product)
    {
        return view('product', [
            'product' => $product
        ]);
    }
}
