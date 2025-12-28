<?php
include_once "./Entity/Paiement.php";
include_once "./Entity/CarteBancaire.php";
include_once "./Entity/Paypal.php";
include_once "./Entity/Virement.php";

class PaiementRepository
{
    private $conn;

    public function __construct(DataBaseConnect $db)
    {
        $this->conn = $db->getConn();
    }

    public function addPaiement(Paiement $Paiement)
    {
        try {
            $query = "INSERT INTO paiement(amount,status, order_id ) VALUES(:amount,:status,:order_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ":amount" => $Paiement->getAmount(),
                ":status" => $Paiement->getStatus(),
                ":order_id" => $Paiement->getCommandeId()
            ]);
            $id = $this->conn->lastInsertId();
            if ($id) {
                $Paiement->setId($id);
                if ($Paiement instanceof Carte) {
                    $query = "INSERT INTO carte_bancaire(paiemrnt_id , card_number) VALUES(:paiement_id, :card_nmumber)";
                    $stmt = $this->conn->prepare($query);
                    $stmt->execute([
                        ":paiement_id" => $Paiement->getId(),
                        ":card_nmumber" => $Paiement->getCreditCardNumber()
                    ]);
                } elseif ($Paiement instanceof PayPal) {
                    $query = "INSERT INTO paypal(paiemrnt_id , email , password) VALUES(:paiement_id, :email, :password)";
                    $stmt = $this->conn->prepare($query);
                    $stmt->execute([
                        ":paiement_id" => $Paiement->getId(),
                        ":email" => $Paiement->getPaiementEmail(),
                        ":password" => $Paiement->getPaiementPassword()
                    ]);
                } elseif ($Paiement instanceof Virement) {
                    $query = "INSERT INTO virement(paiemrnt_id ,rib)  VALUES(:paiement_id , :rib)";
                    $stmt = $this->conn->prepare($query);
                    $stmt->execute([
                        ":paiement_id" => $Paiement->getId(),
                        ":rib" => $Paiement->getRib()
                    ]);
                } else {
                    throw new InvalidArgumentException("Unknown payment type for database insertion.");
                }
            }
            $this->isPaiementFailed();
        } catch (PDOException $error) {
            throw new PDOException("Database error" . $error->getMessage());
        }
    }

    function paiementPaypal($CommandeId, $amount)
    {
        $email = trim(readline("Please enter Email: "));
        $password = trim(readline("Please enter Password: "));
        $status = "COMPLETED";
        $paiementPay = new PayPal($amount, $CommandeId, $status, $email, $password);
        return $paiementPay;
    }

    function paiementVirement($CommandeId, $amount)
    {
        $rib = trim(readline("Please enter the RIB: "));
        $status = "COMPLETED";
        $paiementVir = new Virement($amount, $CommandeId, $status, $rib);
        return $paiementVir;
    }

    function paiementCard($CommandeId, $amount)
    {
        $cardNumber = trim(readline("enter Carde Number: "));
        $status = "COMPLETED";
        $paiementCrd = new Carte($amount, $CommandeId, $status, $cardNumber);
        return $paiementCrd;
    }
    function isPaiementFailed()
    {
        $query = "UPDATE paiement P
                  LEFT JOIN paypal pp ON p.id = pp.paiemrnt_id
                  LEFT JOIN virement v ON p.id = v.paiemrnt_id
                  LEFT JOIN carte_bancaire c ON p.id = c.paiemrnt_id
                  SET p.status = 'FAILED'
                  WHERE pp.paiemrnt_id IS NULL
                  AND v.paiemrnt_id IS NULL
                  AND c.paiemrnt_id IS NULL
                  
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }
}
