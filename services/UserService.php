<?php
require_once '../models/User.php';

class UserService
{
    public function validateUserBody($body)
    {
        if (!isset($body['name']) || empty(filter_var($body['name'], FILTER_SANITIZE_SPECIAL_CHARS))) {
            throw new InvalidArgumentException("O nome do usuario é obrigatório");
        }

        if (!isset($body['email']) || empty(filter_var($body['email'], FILTER_VALIDATE_EMAIL))) {
            throw new InvalidArgumentException("O e-mail é obrigatório deve ser válido");
        }

        if (!isset($body['password']) || empty($body['password'])) {
            throw new InvalidArgumentException("Senha é obrigatória");
        }

        $password = $body['password'];
        $passwordLength = strlen($password);

        if ($passwordLength < 4 || $passwordLength > 8) {
            throw new InvalidArgumentException("A senha deve ter entre 4 e 8 caracteres");
        }
        $user = new User($body['name']);
        $user->setEmail($body['email'] ?? null);
        $user->setPassword($body['password'] ?? null);

        return $user;
    }
}
