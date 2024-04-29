<?php
require_once '../utils/utils.php';
require_once '../DAO/UserDAO.php';
require_once '../models/User.php';
require_once '../services/UserService.php';
class UserController
{

    private $userService;
    private $userDAO;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->userDAO = new UserDAO();
    }

    public function createOne()
    {
        $body = json_decode(json_encode(getBody()), true);
        try {
            $user = $this->userService->validateUserBody($body);

            $result = $this->userDAO->insert($user);

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
        $users = $this->userDAO->findMany();
        response($users, 200);
    }
    public function listOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('ID inválido', 400);


        $user = $this->userDAO->findOne($id);

        if (!$user) responseError('Usuário não encontrado', 404);

        response($user, 200);
    }


    public function updateOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);
        $body = getBody();

        if (!$id) responseError('ID ausente', 400);


        $result = $this->userDAO->updateOne($id, $body);

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


        $userExists = $this->userDAO->findOne($id);

        if (!$userExists) responseError('Usuário não encontrado', 404);

        $result = $this->userDAO->deleteOne($id);

        if ($result['success'] === true) {
            response([], 204);
        } else {
            responseError('Não foi possível excluir o usuário', 400);
        }
    }

    
    public function login()
    {
        $body = json_decode(json_encode(getBody()), true);
        
        if (!isset($body['email']) || !isset($body['password'])) {
            responseError('Credenciais ausentes', 400);
        }

        $email = $body['email'];
        $password = $body['password'];

        $user = $this->userDAO->login($email, $password);

        if ($user) {
           
            response(['message' => 'Login bem-sucedido', 'user_id' => $user['id']], 200);
        } else {
            responseError('Credenciais inválidas', 401);
        }
    }
}
