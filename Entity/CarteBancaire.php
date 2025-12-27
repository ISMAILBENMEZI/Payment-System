<?php

include_once "./Entity/Paiement.php";

class Carte extends Paiement
{
    private $crediteCardNumber;
    private $PaiementId;

    public function __construct($amount, $crediteCardNumber,$PaiementId)
    {
        parent::__construct($amount);
        $this->crediteCardNumber = $crediteCardNumber;
        $this->PaiementId = $PaiementId;
    }


    public function getCreditCardNumber()
    {
        return $this->crediteCardNumber;
    }

    public function getPaiementId()
    {
        return $this->PaiementId;
    }

    public function setCreditCardNumber($crediteCardNumber)
    {
        return $this->crediteCardNumber = $crediteCardNumber;
    }

    public function setPaiementId($PaiementId)
    {
        $this->PaiementId = $PaiementId;
    }
}
