<?php
require_once '../utils.php';
require_once '../models/ClientDAO.php';
require_once '../models/Client.php';

class ClientController
{
    public function createOne()
    {
        $body = getBody();

        $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = sanitizeInput($body, 'email', FILTER_SANITIZE_EMAIL);
        $cpf = sanitizeInput($body, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS);
        $city = sanitizeInput($body, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
        $neighborhood = sanitizeInput($body, 'neighborhood', FILTER_SANITIZE_SPECIAL_CHARS);
        $number = sanitizeInput($body, 'number', FILTER_SANITIZE_SPECIAL_CHARS);
        $street = sanitizeInput($body, 'street', FILTER_SANITIZE_SPECIAL_CHARS);
        $state = sanitizeInput($body, 'state', FILTER_SANITIZE_SPECIAL_CHARS);
        $cep = sanitizeInput($body, 'cep', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$name) responseError("Nome do Cliente é obrigatório", 400);
        

        $client = new Client($name); 
        $client->setEmail($email);
        $client->setCpf($cpf);
        $client->setCity($city);
        $client->setNeighborhood($neighborhood);
        $client->setNumber($number);
        $client->setStreet($street);
        $client->setState($state);
        $client->setCep($cep);

        $clientDAO = new ClientDAO();

        $result = $clientDAO->insert($client);

        if ($result['success'] === true) {
            response(["message" => "Cliente cadastrado com sucesso"], 201);
        } else {
            responseError("Não foi possível cadastrar o cliente", 400);
        }
    }
    public function listAll(){
        $clientDAO = new ClientDAO();
        $clients = $clientDAO->findMany();
        response($clients, 200);
    }

    public function listOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('ID inválido', 400);

        $clientDAO = new ClientDAO();
        $client = $clientDAO->findOne($id);

        if (!$client) responseError('Cliente não encontrado', 404);

        response($client, 200);
    }

    public function updateOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);
        $body = getBody();

        if (!$id) responseError('ID ausente', 400);

        $clientDAO = new ClientDAO();

        $result = $clientDAO->updateOne($id, $body);

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

        $clientDAO = new ClientDAO();

        $clientExists = $clientDAO->findOne($id);

        if (!$clientExists) responseError('Cliente não encontrado', 404);

        $result = $clientDAO->deleteOne($id);

        if ($result['success'] === true) {
            response([], 204);
        } else {
            responseError('Não foi possível excluir o cliente', 400);
        }
    }
}
