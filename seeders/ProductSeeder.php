<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/../utils/DatabaseUtils.php';

try {
    $pdo = DatabaseUtils::getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $productData = [
        ['name' => 'Disco de freio', 'price' => 985.00, 'quant'=>10],
        ['name' => 'Pastilhas de freio', 'price' => 450.00, 'quant'=>10],
        ['name' => 'Filtro de oleo', 'price' => 92.00, 'quant'=>100],
        ['name' => 'Óleo de motor 5w30 sintético', 'price' => 89.00, 'quant'=>1000],
    ];

    $sql = "INSERT INTO products (name, price, quant) VALUES (:name, :price, :quant)";
    $statement = $pdo->prepare($sql);
    
    foreach ($productData as $data) {
        $statement->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'quant' => $data['quant']
        ]);
    }

    echo "Produtos inseridos com sucesso!" . PHP_EOL;
} catch (PDOException $e) {
    die("Erro ao inserir produtos: " . $e->getMessage());
}
?>
