<?php
require_once '../models/Product.php';

class ProductService
{
    public function validateProductBody($body)
    {
        if (!isset($body['name']) || empty(filter_var($body['name'], FILTER_SANITIZE_SPECIAL_CHARS))) {
            throw new InvalidArgumentException("O nome do produto é obrigatório");
        }

        if (!isset($body['price']) || empty(filter_var($body['price'], FILTER_VALIDATE_FLOAT))) {
            throw new InvalidArgumentException("O preço do produto é obrigatório");
        }

        if (!isset($body['quant']) || empty(filter_var($body['quant'], FILTER_VALIDATE_INT))) {
            throw new InvalidArgumentException("A quantidade é obrigatória");
        }

        $product = new Product($body['name']);
        $product->setPrice($body['price'] ?? null);
        $product->setQuant($body['quant'] ?? null);

        return $product;
    }
}
