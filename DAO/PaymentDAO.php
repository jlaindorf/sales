<?php
require_once '../utils/dataBaseUtils.php';

class PaymentDAO
{
    private $connection;

    public function __construct()
    {
        $this->connection = DatabaseUtils::getConnection();
    }

    public function insert(Payment $payment)
    {
        try {
            $sql = "INSERT INTO payments (name, installments)
                    VALUES (:name_value, :installments_value)";

            $statement = $this->connection->prepare($sql);

            $statement->bindValue(":name_value", $payment->getName());
            $statement->bindValue(":installments_value", $payment->getInstallments());

            $statement->execute();

            return ['success' => true];
        } catch (PDOException $error) {
            debug($error->getMessage());
            return ['success' => false];
        }
    }
    public function findMany()
    {
        $sql = "SELECT id,name from payments";

        $statement = ($this->getConnection())->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function findOne($id)
    {
        $sql = "SELECT * FROM payments WHERE id = :id_value";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":id_value", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOne($id, $data)
    {
        $paymentInDatabase = $this->findOne($id);
        if (!$paymentInDatabase) {
            return ['success' => false, 'message' => 'forma de pagamento não encontrada'];
        }

        $sql = "UPDATE payments
                SET name = :name_value,
                    installments = :installments_value
                WHERE id = :id_value";

        $statement = $this->connection->prepare($sql);

        $statement->bindValue(":id_value", $id);
        $statement->bindValue(":name_value", $data->name ?? $paymentInDatabase['name']);
        $statement->bindValue(":installments_value", $data->installments ?? $paymentInDatabase['installments']);

        $statement->execute();

        return ['success' => true];
    }

    public function deleteOne($id)
    {
        try {
            $sql = "DELETE FROM payments WHERE id = :id_value";

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
