<?php

abstract class Paiement
{

    private $status;
    private $CommandeId;
    private $id;
    private $amount;

    public function __construct($amount, $CommandeId, $status = "PENDING")
    {
        $this->status = $status;
        $this->CommandeId = $CommandeId;
        $this->amount  = $amount;
    }


    public function getStatus()
    {
        return $this->status;
    }

    public function getCommandeId()
    {
        return $this->CommandeId;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setStatus($status)
    {
        $status = strtoupper(trim($status));
        $allowed = ['PENDING', 'COMPLETED', 'FAILED'];

        if (!in_array($status, $allowed)) {
            throw new InvalidArgumentException("Invalid order status");
        }

        $this->status = $status;
    }

    public function setCommandeId($CommandeId)
    {
        $this->CommandeId = $CommandeId;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}
