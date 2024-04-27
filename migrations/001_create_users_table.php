<?php
$connectionPath = __DIR__ . '/../connection.php';
require_once $connectionPath;

global $pdo;

try {
    $pdo->beginTransaction();

    $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
        )
    ";

    $pdo->exec($sql);

    $pdo->commit();

    echo "Migration 001 - Tabela 'users' criada com sucesso!" . PHP_EOL;
} catch (PDOException $e) {
    $pdo->rollBack();
    die("Erro ao criar tabela 'users': " . $e->getMessage());
}
?>
