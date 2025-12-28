<?php

include_once "./Entity/Paiement.php";

class Carte extends Paiement
{
    private $crediteCardNumber;
    private $PaiementId;

    public function __construct($amount,$CommandeId, $status,$crediteCardNumber)
    {
        parent::__construct($amount,$CommandeId,$status);
        $this->crediteCardNumber = $crediteCardNumber;
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
        $this->crediteCardNumber = $crediteCardNumber;
    }

    public function setPaiementId($PaiementId)
    {
        $this->PaiementId = $PaiementId;
    }
}
