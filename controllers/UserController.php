<?php
require_once '../models/User.php';
require_once '../models/UserDAO.php';

class UserController
{
    public function createUser()
    {
        
        $pdo = new PDO("pgsql:host=localhost;dbname=api_sales", "docker", "docker");

       
        $userDAO = new UserDAO($pdo);

        
        $userDAO->createTableIfNotExists();

        
        $user = new User("John Doe", "john@example.com", "password123");
        $newUserId = $userDAO->insert($user);

       
        $foundUser = $userDAO->findOneById($newUserId);
        var_dump($foundUser);
    }
}
