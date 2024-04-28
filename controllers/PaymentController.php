<?php
require_once '../utils/utils.php';
require_once '../DAO/PaymentDAO.php';
require_once '../models/Payment.php';

class PaymentController
{
    public function createOne()
    {
        $body = getBody();

        $name = sanitizeInput($body, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $installments = sanitizeInput($body, 'installments', FILTER_VALIDATE_INT);

        $payment = new Payment($name);
        $payment->setInstallments($installments);

        if (!$name) responseError("nome da forma de pagamento é obrigatório", 400);

        $paymentDAO = new PaymentDAO();

        $result =  $paymentDAO->insert($payment);


        if ($result['success'] === true) {
            response(["message" => "Forma de pagamento cadastrada com sucesso"], 201);
        } else {
            responseError("Nao foi possível cadastrar forma de pagamento", 400);
        }
    }
    public function listAll()
    {
        $paymentDAO = new PaymentDAO();
        $payments = $paymentDAO->findMany();
        response($payments, 200);
    }
    public function listOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('ID inválido', 400);

        $paymentDAO = new PaymentDAO();

        $payment = $paymentDAO->findOne($id);

        if (!$payment) responseError('Forma de pagamento não cadastrada', 404);

        response($payment, 200);
    }

    public function updateOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);
        $body = getBody();

        if (!$id) responseError('ID ausente', 400);

        $paymentDAO = new PaymentDAO();

        $result =  $paymentDAO->updateOne($id, $body);

        if ($result['success'] === true) {
            response(["message" => "Forma de pagamento atualizada com sucesso"], 200);
        } else {
            responseError('Não foi possível atualizar a forma de pagamento', 400);
        }
    }

    public function deleteOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('ID inválido', 400);

        $paymentDAO = new PaymentDAO();

        $paymentExists = $paymentDAO->findOne($id);

        if (!$paymentExists) responseError('Forma de pagamento não cadastrada', 404);

        $result = $paymentDAO->deleteOne($id);

        if ($result['success'] === true) {
            response([], 204);
        } else {
            responseError('Não foi possível excluir a forma de pagamento', 400);
        }
    }
}
