<?php
class Product
{
    private $id;
    private $name;
    private $price;
    private $quant;
    private $created_at;
    private $updated_at;

    public function __construct($name = null)
    {
        $this->name = $name;

    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getQuant()
    {
        return $this->quant;
    }

    public function setQuant($quant)
    {
        $this->quant = $quant;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
