<?php
class UserDAO
{
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function createTableIfNotExists()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL
            )
        ";

        try {
            $this->connection->exec($sql);
            echo "Tabela 'users' criada com sucesso!";
        } catch (PDOException $e) {
            die("Erro ao criar tabela 'users': " . $e->getMessage());
        }
    }

    public function insert(User $user)
    {
        $sql = "INSERT INTO users (name, email, password)
                VALUES (:name, :email, :password)";

        $statement = $this->connection->prepare($sql);
        $statement->execute([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ]);

        return $this->connection->lastInsertId();
    }

    public function findOneById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $id]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    
}
