<?php
require_once '../utils/utils.php';
require_once '../DAO/PaymentDAO.php';
require_once '../models/Payment.php';
require_once '../services/PaymentService.php';
class PaymentController
{
    public function createOne()
    {
        $body = json_decode(json_encode(getBody()), true);
        try {
            $paymentService = new PaymentService();
            $payment = $paymentService->validatePaymentBody($body);
    
            $paymentDAO = new PaymentDAO();
            
            $result = $paymentDAO->insert($payment);
    
            if ($result['success'] === true) {
                response(["message" => "Pagamento cadastrado com sucesso"], 201);
            } else {
                responseError("Não foi possível cadastrar o pagamento", 400);
            }
        } catch (InvalidArgumentException $e) {
            responseError($e->getMessage(), 400);
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
