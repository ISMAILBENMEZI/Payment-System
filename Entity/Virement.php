<?php

include_once "./Entity/Paiement.php";

class Virement extends Paiement
{
    private $rib;
    private $PaiementId;

    public function __construct($amount,$CommandeId,$status,$rib)
    {
        parent::__construct($amount,$CommandeId,$status);
        $this->rib = $rib;
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
