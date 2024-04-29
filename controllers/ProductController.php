<?php
require_once '../utils/utils.php';
require_once '../DAO/ProductDAO.php';
require_once '../models/Product.php';
require_once '../services/ProductService.php';
class ProductController
{
    private $productDAO;
    private $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->productDAO = new ProductDAO();
    }

    public function createOne()
    {
        $body = json_decode(json_encode(getBody()), true);
        try {

            $product = $this->productService->validateproductBody($body);

            $result = $this->productDAO->insert($product);

            if ($result['success'] === true) {
                response(["message" => "Produto cadastrado com sucesso"], 201);
            } else {
                responseError("Não foi possível cadastrar o produto", 400);
            }
        } catch (InvalidArgumentException $e) {
            responseError($e->getMessage(), 400);
        }
    }

    public function listAll()
    {
        $products = $$this->productDAO->findMany();
        response($products, 200);
    }
    public function listOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('ID inválido', 400);


        $product = $$this->productDAO->findOne($id);

        if (!$product) responseError('Produto não cadastrado', 404);

        response($product, 200);
    }

    public function updateOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);
        $body = getBody();

        if (!$id) responseError('ID ausente', 400);


        $result =  $$this->productDAO->updateOne($id, $body);

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


        $productExists = $$this->productDAO->findOne($id);

        if (!$productExists) responseError('Produto não cadastrado', 404);

        $result = $$this->productDAO->deleteOne($id);

        if ($result['success'] === true) {
            response([], 204);
        } else {
            responseError('Não foi possível excluir o produto', 400);
        }
    }
}
