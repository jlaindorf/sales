<?php

class Payment
{
    private $id;
    private $name;
    private $parcelas;
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

    public function getParcelas()
    {
        return $this->parcelas;
    }

    public function setParcelas($parcelas)
    {
        $this->parcelas = $parcelas;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
}