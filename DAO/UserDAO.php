<?php
require_once '../utils/dataBaseUtils.php';
class UserDAO
{
    private $connection;

    public function __construct()
    {
        $this->connection = DatabaseUtils::getConnection();
    }

    public function insert(User $user)
    {
        try {
            $sql = "INSERT INTO users (name, email, password)
                VALUES (:name_value, :email_value, :password_value)";

            $statement = $this->connection->prepare($sql);

            $statement->bindValue(":name_value", $user->getName());
            $statement->bindValue(":email_value", $user->getEmail());
            $statement->bindValue(":password_value", $user->getPassword());

            $statement->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function findOneById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $id]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function findMany()
    {
        $sql = "SELECT id,name from users";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function findOne($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id_value";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":id_value", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOne($id, $data)
    {
        $userInDatabase = $this->findOne($id);

        if (!$userInDatabase) {
            return ['success' => false, 'message' => 'Usuário não encontrado'];
        }


        $sql = "UPDATE users 
                SET name = :name_value,
                    email = :email_value,
                    password = :password_value
                WHERE id = :id_value";

        $statement = $this->connection->prepare($sql);

        $statement->bindValue(":id_value", $id);
        $statement->bindValue(":name_value", $data->name ?? $userInDatabase['name']);
        $statement->bindValue(":email_value", $data->email ?? $userInDatabase['email']);
        $statement->bindValue(":password_value", $data->password ?? $userInDatabase['password']);

        $statement->execute();

        return ['success' => true];
    }

    public function deleteOne($id)
    {
        try {
            $sql = "DELETE FROM users WHERE id = :id_value";

            $statement = $this->connection->prepare($sql);
            $statement->bindValue(":id_value", $id);
            $statement->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }

    public function login($email, $password)
{
    $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
    $statement = $this->connection->prepare($sql);
    $statement->bindValue(":email", $email);
    $statement->bindValue(":password", $password);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}
    public function getConnection()
    {
        return $this->connection;
    }
}
