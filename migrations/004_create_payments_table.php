<?php

$connectionPath = __DIR__ . '/../connection.php';
require_once $connectionPath;


global $pdo;

try {
    $pdo->beginTransaction();

    $sql = "CREATE TABLE IF NOT EXISTS payments (
        id SERIAL PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        installments INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);

    $pdo->commit();

    echo "Migration 004- Tabela 'payments' criada com sucesso!" . PHP_EOL;
} catch (PDOException $e) {
    $pdo->rollBack();
    die("Erro ao criar tabela 'payments': " . $e->getMessage());
}
