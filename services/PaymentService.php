<?php
require_once '../models/Payment.php';

class PaymentService
{
    public function validatePaymentBody($body)
    {
        if (!isset($body['name']) || empty($body['name'])) {
            throw new InvalidArgumentException("O nome da forma de pagamento é obrigatório");
        }
        
        $payment = new Payment($body['name']);
        $payment->setInstallments($body['installments'] ?? null);
        
        return $payment;
    }
}
?>
