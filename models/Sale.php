<?php
class Sale
{
    private $id;
    private $client_id;
    private $product_id;
    private $quant;
    private $payment_id;
    private $total_price;

    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getClientId()
    {
        return $this->client_id;
    }

    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    public function getQuant()
    {
        return $this->quant;
    }

    public function setQuant($quant)
    {
        $this->quant = $quant;
    }

    public function getPaymentId()
    {
        return $this->payment_id;
    }

    public function setPaymentId($payment_id)
    {
        $this->payment_id = $payment_id;
    }

    public function getTotalPrice()
    {
        return $this->total_price;
    }

    public function setTotalPrice($total_price)
    {
        $this->total_price = $total_price;
    }
}
