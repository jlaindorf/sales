<?php
require_once '../utils/utils.php';
require_once '../DAO/ProductDAO.php';
require_once '../models/Product.php';

class ProductController
{
    public function createOne()
    {
        $body = getBody();

        $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $price = sanitizeInput($body, 'price', FILTER_VALIDATE_FLOAT);
        $quant = sanitizeInput($body, 'quant', FILTER_VALIDATE_INT);



        $product = new Product($name);
        $product->setPrice($price);
        $product->setQuant($quant);

        $productDAO = new ProductDAO();

        $result =  $productDAO->insert($product);


        if ($result['success'] === true) {
            response(["message" => "Produto cadastrado com sucesso"], 201);
        } else {
            responseError("Nao foi possível cadastrar o produto", 400);
        }
    }
    public function listAll()
    {
        $productDAO = new ProductDAO();
        $products = $productDAO->findMany();
        response($products, 200);
    }
    public function listOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('ID inválido', 400);

        $productDAO = new ProductDAO();

        $product = $productDAO->findOne($id);

        if (!$product) responseError('Produto não cadastrado', 404);

        response($product, 200);
    }

    public function updateOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);
        $body = getBody();

        if (!$id) responseError('ID ausente', 400);

        $productDAO = new ProductDAO();

        $result =  $productDAO->updateOne($id, $body);

        if ($result['success'] === true) {
            response(["message" => "Produto atualizado com sucesso"], 200);
        } else {
            responseError('Não foi possível atualizar o Produto', 400);
        }
    }

    public function deleteOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('ID inválido', 400);

        $productDAO = new ProductDAO();

        $productExists = $productDAO->findOne($id);

        if (!$productExists) responseError('Produto não cadastrado', 404);

        $result = $productDAO->deleteOne($id);

        if ($result['success'] === true) {
            response([], 204);
        } else {
            responseError('Não foi possível excluir o produto', 400);
        }
    }
}
