<?php

include_once "./Entity/Paiement.php";

class Virement extends Paiement
{
    private $rib;
    private $PaiementId;

    public function __construct($amount , $rib, $PaiementId)
    {
        return parent::__construct($amount);
        $this->rib = $rib;
        $this->PaiementId = $PaiementId;
    }

    public function getRib()
    {
        return $this->rib;
    }

    public function getPaiementId()
    {
        return $this->PaiementId;
    }

    public function setRib($rib)
    {
        $this->rib = $rib;
    }

    public function setPaiementId($PaiementId)
    {
        $this->PaiementId = $PaiementId;
    }
}