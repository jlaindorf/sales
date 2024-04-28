<?php
require_once '../utils/utils.php';
require_once '../DAO/UserDAO.php';
require_once '../models/User.php';
require_once '../services/UserService.php';
class UserController
{
    public function createOne()
    {
        $body = json_decode(json_encode(getBody()), true);
        try {
            $userService = new UserService();
            $user = $userService->validateUserBody($body);

            $userDAO = new UserDAO();
            $result = $userDAO->insert($user);

            if ($result['success'] === true) {
                response(["message" => "Usuário cadastrado com sucesso"], 201);
            } else {
                responseError("Não foi possível cadastrar o usuário", 400);
            }
        } catch (InvalidArgumentException $e) {
            responseError($e->getMessage(), 400);
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

        $userDAO = new UserDAO();

        $user = $userDAO->findOne($id);

        if (!$user) responseError('Usuário não encontrado', 404);

        response($user, 200);
    }


    public function updateOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);
        $body = getBody();

        if (!$id) responseError('ID ausente', 400);

        $userDAO = new UserDAO();

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

        $userDAO = new UserDAO();

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
