<?php
$connectionPath = __DIR__ . '/../connection.php';
require_once $connectionPath;

global $pdo;

try {

    $pdo->beginTransaction();

    $sql="
        CREATE TABLE IF NOT EXISTS sales (
        id SERIAL PRIMARY KEY,
        user_id INT NOT NULL,
        client_id INT NOT NULL,
        product_id INT NOT NULL,
        quant INT NOT NULL,
        total_price NUMERIC(10, 2) NOT NULL,
        payment_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (client_id) REFERENCES clients(id),
        FOREIGN KEY (product_id) REFERENCES products(id),
        FOREIGN KEY (payment_id) REFERENCES payments(id)
     )
     ";
     

    $pdo->exec($sql);

    $pdo->commit();

    echo "Migration 005 - Tabela 'sales' criada com sucesso!" . PHP_EOL;
} catch (PDOException $e) {
    $pdo->rollBack();
    die("Erro ao criar tabela 'sales': " . $e->getMessage());
}
?>
