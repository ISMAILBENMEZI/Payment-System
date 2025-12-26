<?php

class Commande
{
    private $total_amount;
    private $status;
    private $id;
    private $clientId;

    public function __construct($total_amount, $clientId, $status = "PENDING")
    {
        $this->setMontantTotal($total_amount);
        $this->setStatus($status);
        $this->setclientId($clientId);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function getMontantTotal()
    {
        return $this->total_amount;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setclientId($clientId)
    {
        $this->clientId = $clientId;
    }

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function setMontantTotal($total_amount)
    {
        if ($total_amount <= 0) {
            throw new InvalidArgumentException("Total amount must be positive");
        }

        $this->total_amount = $total_amount;
    }

    public function setStatus($status)
    {
        $status = strtoupper(trim($status));
        $allowed = ['PENDING', 'PAID', 'CANCELLED'];

        if (!in_array($status, $allowed)) {
            throw new InvalidArgumentException("Invalid order status");
        }

        $this->status = $status;
    }
}
