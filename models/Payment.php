<?php
class Payment
{
    private $id;
    private $name;
    private $installments;
    private $created_at;

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

    public function getinstallments()
    {
        return $this->installments;
    }

    public function setinstallments($installments)
    {
        $this->installments = $installments;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
}
