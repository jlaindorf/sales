<?php
require_once '../utils/utils.php';
require_once '../models/UserDAO.php';
require_once '../models/User.php';

class UserController
{
    public function createOne()
    {
        $body = getBody();

        $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = sanitizeInput($body, 'email', FILTER_SANITIZE_EMAIL);
        $password = sanitizeInput($body, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$name || !$email || !$password) {
            responseError("Nome, email e senha são obrigatórios", 400);
        }

        if (strlen($password) < 4 || strlen($password) > 8) {
            responseError("A senha deve ter entre 4 e 8 caracteres", 400);
        }

        $user = new User($name);
        $user->setEmail($email);
        $user->setPassword($password);


        $userDAO = new UserDAO();

        $result = $userDAO->insert($user);


        if ($result['success'] === true) {
            response(["message" => "Usuário cadastrado com sucesso"], 201);
        } else {
            responseError("Nao foi possível cadastrar o usuario", 400);
        }
    }
    public function listAll()
    {
        $userDAO = new UserDAO();
        $users = $userDAO->findMany();
        response($users, 200);
    }
    public function listOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('ID inválido', 400);


        $pdo = new PDO("pgsql:host=localhost;dbname=api_sales", "admin", "admin");
        $userDAO = new UserDAO($pdo);

        $user = $userDAO->findOne($id);

        if (!$user) responseError('Usuário não encontrado', 404);

        response($user, 200);
    }

    public function updateOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);
        $body = getBody();

        if (!$id) responseError('ID ausente', 400);


        $pdo = new PDO("pgsql:host=localhost;dbname=api_sales", "admin", "admin");
        $userDAO = new UserDAO($pdo);

        $result = $userDAO->updateOne($id, $body);

        if ($result['success'] === true) {
            response(["message" => "Usuário atualizado com sucesso"], 200);
        } else {
            responseError('Não foi possível atualizar o usuário', 400);
        }
    }

    public function deleteOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('ID inválido', 400);


        $pdo = new PDO("pgsql:host=localhost;dbname=api_sales", "admin", "admin");
        $userDAO = new UserDAO($pdo);

        $userExists = $userDAO->findOne($id);

        if (!$userExists) responseError('Usuário não encontrado', 404);

        $result = $userDAO->deleteOne($id);

        if ($result['success'] === true) {
            response([], 204);
        } else {
            responseError('Não foi possível excluir o usuário', 400);
        }
    }
}
