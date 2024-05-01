<?php

require_once '../models/Sale.php';

class SaleService
{
    public function validateSaleBody($body)
    {
        if (!isset($body['client_id']) || empty($body['client_id'])) {
            throw new InvalidArgumentException("O ID do cliente é obrigatório");
        }

        if (!isset($body['product_id']) || empty($body['product_id'])) {
            throw new InvalidArgumentException("O ID do produto é obrigatório");
        }

        if (!isset($body['quant']) || empty($body['quant'])) {
            throw new InvalidArgumentException("A quantidade é obrigatória");
        }

        if (!isset($body['payment_id']) || empty($body['payment_id'])) {
            throw new InvalidArgumentException("O ID da forma de pagamento é obrigatório");
        }

        $sale = new Sale();
        
        $sale->setClientId($body['client_id']);
        $sale->setProductId($body['product_id']);
        $sale->setQuant($body['quant']);
        $sale->setPaymentId($body['payment_id']);
        $sale->setTotalPrice($body['total_price']);
     
        return $sale;
    }

}
