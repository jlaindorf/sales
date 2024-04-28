<?php

$connectionPath = __DIR__ . '/../connection.php';
require_once $connectionPath;


global $pdo;

try {
    $pdo->beginTransaction();

    $sql = "CREATE TABLE IF NOT EXISTS products (
        id SERIAL PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        price NUMERIC(10, 2) NOT NULL,
        quant INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);

    $pdo->commit();

    echo "Migration 002 - Tabela 'products' criada com sucesso!" . PHP_EOL;
} catch (PDOException $e) {
    $pdo->rollBack();
    die("Erro ao criar tabela 'products': " . $e->getMessage());
}
