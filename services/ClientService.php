<?php
require_once '../models/Client.php';

class ClientService
{
    public function validateClientData($data)
    {
        if (!isset($data['name']) || empty(filter_var($data['name'], FILTER_SANITIZE_SPECIAL_CHARS))) {
            throw new InvalidArgumentException("O nome do cliente é obrigatório");
        }
    
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("O e-mail fornecido não é válido");
        }

        if (isset($data['cpf']) && !filter_var($data['cpf'], FILTER_SANITIZE_SPECIAL_CHARS)) {
            throw new InvalidArgumentException("O CPF fornecido não é válido");
        }

        $client = new Client($data['name']);
        $client->setEmail($data['email'] ?? null);
        $client->setCpf($data['cpf'] ?? null);
        $client->setCity($data['city'] ?? null);
        $client->setNeighborhood($data['neighborhood'] ?? null);
        $client->setNumber($data['number'] ?? null);
        $client->setStreet($data['street'] ?? null);
        $client->setState($data['state'] ?? null);
        $client->setCep($data['cep'] ?? null);

        return $client;
    }
}

