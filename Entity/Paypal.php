<?php

include_once "./Entity/Paiement.php";

class PayPal extends Paiement
{
    private $paiementEmail;
    private $paiementPassword;
    private $PaiementId;

    public function __construct($amount, $paiementEmail, $paiementPassword,$PaiementId)
    {
        parent::__construct($amount);
        $this->paiementEmail = $paiementEmail;
        $this->paiementPassword = $paiementPassword;
        $this->PaiementId = $PaiementId;
    }

    public function getPaiementEmail()
    {
        return $this->paiementEmail;
    }

    public function getPaiementPassword()
    {
        return $this->paiementPassword;
    }

    public function getPaiementId()
    {
        return $this->PaiementId;
    }

    public function setPaiementPassword($paiementPassword)
    {
        if (empty(trim($paiementPassword)) or preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $paiementPassword)) {
            $this->paiementEmail = $paiementPassword;
        } else {
            throw new InvalidArgumentException("Password Invalide");
        }
    }

    public function setPaiementEmail($paiementEmail)
    {
        if (empty(trim($paiementEmail)) or !filter_var($paiementEmail, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email Invalide");
        }
        $this->paiementEmail = $paiementEmail;
    }

    public function setPaiementId($PaiementId)
    {
        $this->PaiementId = $PaiementId;
    }
}
