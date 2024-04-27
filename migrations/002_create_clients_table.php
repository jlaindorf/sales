<?php

$connectionPath = __DIR__ . '/../connection.php';
require_once $connectionPath;


global $pdo;

try {
    $pdo->beginTransaction();

    $sql = "
    CREATE TABLE IF NOT EXISTS clients (
        id SERIAL PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        cpf VARCHAR(14) NOT NULL UNIQUE,
        city VARCHAR(50),
        neighborhood VARCHAR(50),
        number VARCHAR(30),
        street VARCHAR(30),
        state VARCHAR(2),
        cep VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";

    $pdo->exec($sql);

    $pdo->commit();

    echo "Migration 002 - Tabela 'clients' criada com sucesso!" . PHP_EOL;
} catch (PDOException $e) {
    $pdo->rollBack();
    die("Erro ao criar tabela 'clients': " . $e->getMessage());
}
?>
