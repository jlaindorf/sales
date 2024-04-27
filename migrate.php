<?php
require_once 'connection.php'; 


$migrationDir = __DIR__ . '/migrations';


$migrations = scandir($migrationDir);


foreach ($migrations as $migration) {
    if ($migration !== '.' && $migration !== '..') {
       
        $migrationPath = $migrationDir . '/' . $migration;

       
        if (is_file($migrationPath)) {
            require_once $migrationPath;
        }
    }
}
