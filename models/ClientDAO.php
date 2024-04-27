<?php

class ClientDAO
{
    private $connection;

    public function __construct()
    {
        $this->connection = new PDO("pgsql:host=localhost;dbname=api_sales", "admin", "admin");
    }

    public function insert(Client $client)
    {
        try {
            $sql = "INSERT INTO clients (name, email, cpf, city, neighborhood, number, street, state, cep)
                    VALUES (:name_value, :email_value, :cpf_value, :city_value, :neighborhood_value, 
                            :number_value, :street_value, :state_value, :cep_value)";
            
            $statement = $this->connection->prepare($sql);

            $statement->bindValue(":name_value", $client->getName());
            $statement->bindValue(":email_value", $client->getEmail());
            $statement->bindValue(":cpf_value", $client->getCpf());
            $statement->bindValue(":city_value", $client->getCity());
            $statement->bindValue(":neighborhood_value", $client->getNeighborhood());
            $statement->bindValue(":number_value", $client->getNumber());
            $statement->bindValue(":street_value", $client->getStreet());
            $statement->bindValue(":state_value", $client->getState());
            $statement->bindValue(":cep_value", $client->getCep());

            $statement->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function findOne($id)
    {
        $sql = "SELECT * FROM clients WHERE id = :id_value";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":id_value", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOne($id, $data)
    {
        $clientInDatabase = $this->findOne($id);

        $sql = "UPDATE clients 
                SET name = :name_value,
                    email = :email_value,
                    cpf = :cpf_value,
                    city = :city_value,
                    neighborhood = :neighborhood_value,
                    number = :number_value,
                    street = :street_value,
                    state = :state_value,
                    cep = :cep_value
                WHERE id = :id_value";

        $statement = $this->connection->prepare($sql);

        $statement->bindValue(":id_value", $id);
        $statement->bindValue(":name_value", $data->name ?? $clientInDatabase['name']);
        $statement->bindValue(":email_value", $data->email ?? $clientInDatabase['email']);
        $statement->bindValue(":cpf_value", $data->cpf ?? $clientInDatabase['cpf']);
        $statement->bindValue(":city_value", $data->city ?? $clientInDatabase['city']);
        $statement->bindValue(":neighborhood_value", $data->neighborhood ?? $clientInDatabase['neighborhood']);
        $statement->bindValue(":number_value", $data->number ?? $clientInDatabase['number']);
        $statement->bindValue(":street_value", $data->street ?? $clientInDatabase['street']);
        $statement->bindValue(":state_value", $data->state ?? $clientInDatabase['state']);
        $statement->bindValue(":cep_value", $data->cep ?? $clientInDatabase['cep']);

        $statement->execute();

        return ['success' => true];
    }

    public function deleteOne($id)
    {
        try {
            $sql = "DELETE FROM clients WHERE id = :id_value";

            $statement = $this->connection->prepare($sql);
            $statement->bindValue(":id_value", $id);
            $statement->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
