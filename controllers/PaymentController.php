<?php
require_once '../utils/utils.php';
require_once '../DAO/PaymentDAO.php';
require_once '../models/Payment.php';
require_once '../services/PaymentService.php';
class PaymentController
{

    private $paymentService;
    private $paymentDAO;

    public function __construct()
    {
        $this->paymentService = new PaymentService();
        $this->paymentDAO = new PaymentDAO();
    }

    public function createOne()
    {
        $body = json_decode(json_encode(getBody()), true);
        try {
            $payment = $this->paymentService->validatePaymentBody($body);

            $result = $this->paymentDAO->insert($payment);

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
        $payments = $this->paymentDAO->findMany();
        response($payments, 200);
    }
    public function listOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);

        if (!$id) responseError('ID inválido', 400);

        $payment = $this->paymentDAO->findOne($id);

        if (!$payment) responseError('Forma de pagamento não cadastrada', 404);

        response($payment, 200);
    }

    public function updateOne()
    {
        $id = sanitizeInput($_GET, 'id', FILTER_VALIDATE_INT, false);
        $body = getBody();

        if (!$id) responseError('ID ausente', 400);

        $result =  $this->paymentDAO->updateOne($id, $body);

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

        $paymentExists = $this->paymentDAO->findOne($id);

        if (!$paymentExists) responseError('Forma de pagamento não cadastrada', 404);

        $result = $this->paymentDAO->deleteOne($id);

        if ($result['success'] === true) {
            response([], 204);
        } else {
            responseError('Não foi possível excluir a forma de pagamento', 400);
        }
    }
}
