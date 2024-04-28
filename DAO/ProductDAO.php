<?php
require_once '../utils/dataBaseUtils.php';

class ProductDAO
{
    private $connection;

    public function __construct()
    {
        $this->connection = DatabaseUtils::getConnection();
    }

    public function insert(Product $product)
    {
        try {
            $sql = "INSERT INTO products (name, price, quant)
                    VALUES (:name_value, :price_value, :quant_value)";

            $statement = $this->connection->prepare($sql);

            $statement->bindValue(":name_value", $product->getName());
            $statement->bindValue(":price_value", $product->getPrice());
            $statement->bindValue(":quant_value", $product->getQuant());

            $statement->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }
    public function findMany()
    {
        $sql = "SELECT id,name from products";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function findOne($id)
    {
        $sql = "SELECT * FROM products WHERE id = :id_value";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":id_value", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOne($id, $data)
    {
        $productInDatabase = $this->findOne($id);

        $sql = "UPDATE products
                SET name = :name_value,
                    price = :price_value,
                    quant = :quant_value
                WHERE id = :id_value";

        $statement = $this->connection->prepare($sql);

        $statement->bindValue(":id_value", $id);
        $statement->bindValue(":name_value", $data->name ?? $productInDatabase['name']);
        $statement->bindValue(":price_value", $data->email ?? $productInDatabase['price']);
        $statement->bindValue(":quant_value", $data->email ?? $productInDatabase['quant']);

        $statement->execute();

        return ['success' => true];
    }

    public function deleteOne($id)
    {
        try {
            $sql = "DELETE FROM products WHERE id = :id_value";

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
