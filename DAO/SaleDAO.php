<?php
require_once '../utils/dataBaseUtils.php';

class SaleDAO
{
    private $connection;

    public function __construct()
    {
        $this->connection = DatabaseUtils::getConnection();
    }


    private function updateProductQuantity($productId, $soldQuantity)
    {
        try {

            $sqlUpdate = "UPDATE products 
                      SET quant = quant - :quant_value 
                      WHERE id = :product_id_value";

            $statementUpdate = $this->connection->prepare($sqlUpdate);


            $statementUpdate->bindValue(":quant_value", $soldQuantity);
            $statementUpdate->bindValue(":product_id_value", $productId);


            $statementUpdate->execute();

            return true;
        } catch (PDOException $error) {
            debug($error->getMessage());
            return false;
        }
    }
   

    public function insert(Sale $sale)
    {
        try {
            $this->connection->beginTransaction();
    
            $sql = "INSERT INTO sales (client_id, product_id, quant, payment_id, total_price)
                VALUES (:client_id_value, :product_id_value, :quant_value, :payment_id_value, :total_price_value)";
    
            $statement = $this->connection->prepare($sql);
    
            $statement->bindValue(":client_id_value", $sale->getClientId());
            $statement->bindValue(":product_id_value", $sale->getProductId());
            $statement->bindValue(":quant_value", $sale->getQuant());
            $statement->bindValue(":payment_id_value", $sale->getPaymentId());
            $statement->bindValue(":total_price_value", $sale->getTotalPrice()); 
            
            $statement->execute();
    
            $this->updateProductQuantity($sale->getProductId(), $sale->getQuant());
    
            $this->connection->commit();
    
            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            $this->connection->rollBack();
            return ['success' => false];
        }
    }

    public function findMany()
    {
        $sql = "SELECT id FROM sales";

        $statement = $this->connection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function findOne($id)
    {
        $sql = "SELECT * FROM sales WHERE id = :id_value";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":id_value", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOne($id, $data)
    {
        $saleInDatabase = $this->findOne($id);
        if (!$saleInDatabase) {
            return ['success' => false, 'message' => 'Venda não encontrada'];
        }

        $sql = "UPDATE sales
                SET client_id = :client_id_value,
                    product_id = :product_id_value,
                    quant = :quant_value,
                    payment_id = :payment_id_value,
                    total_price = :total_price_value
                WHERE id = :id_value";

        $statement = $this->connection->prepare($sql);

        $statement->bindValue(":client_id_value", $data['client_id'] ?? $saleInDatabase['client_id']);
        $statement->bindValue(":product_id_value", $data['product_id'] ?? $saleInDatabase['product_id']);
        $statement->bindValue(":quant_value", $data['quant'] ?? $saleInDatabase['quant']);
        $statement->bindValue(":payment_id_value", $data['payment_id'] ?? $saleInDatabase['payment_id']);
        $statement->bindValue(":total_price_value", $data['total_price'] ?? $saleInDatabase['total_price']);
        $statement->bindValue(":id_value", $id);

        $statement->execute();
        return ['success' => true];
    }


    public function deleteOne($id)
    {
        try {
            $sql = "DELETE FROM sales WHERE id = :id_value";

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
