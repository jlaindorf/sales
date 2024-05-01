<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/../utils/DatabaseUtils.php';


try {
    $pdo = DatabaseUtils::getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $paymentData = [
        ['name' => 'Dinheiro', 'installments' => 1],
        ['name' => 'Pix','installments' => 1],
        ['name' => 'Credito a vista', 'installments' => 1],
        ['name' => 'Credito parcelado', 'installments' => 2],
        ['name' => 'Credito parcelado', 'installments' => 3],
        ['name' => 'Credito parcelado', 'installments' => 4]
    ];

    $sql = "INSERT INTO payments (name, installments) VALUES (:name, :installments)";
    $statement = $pdo->prepare($sql);

    foreach ($paymentData as $data) {
        if (isset($data['installments'])) {
            $statement->execute($data);
        } else {
            $statement->execute(['name' => $data['name'], 'installments' => null]);
        }
    }

    echo "Formas de pagamento inseridas com sucesso!" . PHP_EOL;
} catch (PDOException $e) {
    die("Erro ao inserir formas de pagamento: " . $e->getMessage());
}
