<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../connection.php';
try {

    $pdo = new PDO("pgsql:host=localhost;dbname=api_sales", "admin", "admin");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $userData = [
        'name' => 'Julio',
        'email' => 'julio@gmail.com',
        'password' => 'admin'
    ];

    $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
    $statement = $pdo->prepare($sql);

    $statement->execute($userData);

    echo "Usuário inserido com sucesso!" . PHP_EOL;
} catch (PDOException $e) {
    die("Erro ao inserir usuário: " . $e->getMessage());
}
