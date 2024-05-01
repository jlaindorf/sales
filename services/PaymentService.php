<?php
require_once '../models/Payment.php';

class PaymentService
{
    public function validatePaymentBody($body)
    {
        if (!isset($body['name']) || empty($body['name'])) {
            throw new InvalidArgumentException("O nome da forma de pagamento é obrigatório");
        }
        if (!isset($body['installments']) || empty($body['installments'])) {
            throw new InvalidArgumentException("A quantidade de parcelas é obrigatório(se a vista considerar 1");
        }
        
        $payment = new Payment($body['name']);
        $payment->setInstallments($body['installments']);
        
        return $payment;
    }
}
?>
