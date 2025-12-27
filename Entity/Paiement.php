<?php

abstract class Paiement
{

    private $status;
    private $CommandeId;
    private $id;


    public function __construct($CommandeId, $status = "PENDING")
    {
        $this->status = $status;
        $this->CommandeId = $CommandeId;
    }


    public function getStatus()
    {
        return $this->status;
    }

    public function getCommandeId()
    {
        return $this->CommandeId;
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

    public function setCommandeId($CommandeId)
    {
        $this->CommandeId = $CommandeId;
    }
}
