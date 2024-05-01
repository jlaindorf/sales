<?php

require_once '../services/SaleService.php';
require_once '../DAO/SaleDAO.php';
require_once '../utils/utils.php';

class SaleController
{
    private $saleService;
    private $saleDAO;

    public function __construct()
    {
        $this->saleService = new SaleService();
        $this->saleDAO = new SaleDAO();
    }

    public function createOne()
    {   
        $body = json_decode(file_get_contents("php://input"), true);
        try {

            $validatedSale = $this->saleService->validateSaleBody($body);


            $result = $this->saleDAO->insert($validatedSale);

            if ($result['success'] === true) {
                response(["message" => "Venda cadastrada com sucesso"], 201);
            } else {
                responseError("Não foi possível cadastrar o", 400);
            }
        } catch (InvalidArgumentException $e) {
            responseError($e->getMessage(), 400);
        }
    }

    public function listAll()
    {
        $sales = $this->saleDAO->findMany();
        response($sales, 200);
    }

    public function listOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('ID inválido', 400);

        $sale = $this->saleDAO->findOne($id);

        if (!$sale) responseError('Forma de pagamento não cadastrada', 404);

        response($sale, 200);
    }

    public function updateOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);
        $body = getBody();

        if (!$id) responseError('ID ausente', 400);


        $result = $this->saleDAO->updateOne($id, $body);

        if ($result['success'] === true) {
            response(["message" => "Usuário atualizado com sucesso"], 200);
        } else {
            responseError('Não foi possível atualizar o usuário', 400);
        }
    }


    public function deleteOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('ID inválido', 400);

        $saleExists = $this->saleDAO->findOne($id);

        if (!$saleExists) responseError('venda não encontrada', 404);

        $result = $this->saleDAO->deleteOne($id);

        if ($result['success'] === true) {
            response([], 204);
        } else {
            responseError('Não foi possível excluir a venda', 400);
        }
    }
}
