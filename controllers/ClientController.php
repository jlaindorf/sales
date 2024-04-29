<?php
require_once '../utils/utils.php';
require_once '../DAO/ClientDAO.php';
require_once '../models/Client.php';
require_once '../services/ClientService.php';

class ClientController
{
    private $clientDAO;
    private $clientService;

    public function __construct()
    {
        $this->clientService = new ClientService();
        $this->clientDAO = new ClientDAO();
    }



    public function createOne()
    {
        $body = json_decode(json_encode(getBody()), true);
        try {
            
            $client = $this->clientService->validateClientData($body);

            $result = $this->clientDAO->insert($client);

            if ($result['success'] === true) {
                response(["message" => "Cliente cadastrado com sucesso"], 201);
            } else {
                responseError("Não foi possível cadastrar o cliente", 400);
            }
        } catch (InvalidArgumentException $e) {
            responseError($e->getMessage(), 400);
        }
    }

    public function listAll()
    {
        $clients = $this->clientDAO->findMany();
        response($clients, 200);
    }

    public function listOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('ID inválido', 400);

        $client = $this->clientDAO->findOne($id);

        if (!$client) responseError('Cliente não encontrado', 404);

        response($client, 200);
    }

    public function updateOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);
        $body = getBody();

        if (!$id) responseError('ID ausente', 400);

        $result =$this->clientDAO->updateOne($id, $body);

        if ($result['success'] === true) {
            response(["message" => "Cliente atualizado com sucesso"], 200);
        } else {
            responseError('Nao foi possivel atualizar o cliente', 400);
        }
    }

    public function deleteOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('ID inválido', 400);

        $clientExists = $this->clientDAO->findOne($id);

        if (!$clientExists) responseError('Cliente não encontrado', 404);

        $result = $this->clientDAO->deleteOne($id);

        if ($result['success'] === true) {
            response([], 204);
        } else {
            responseError('Não foi possível excluir o cliente', 400);
        }
    }
}
