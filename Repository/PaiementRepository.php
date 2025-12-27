<?php
include_once "./Entity/Paiement.php";


class PaiementRepository
{
    private $conn;

    public function __construct(DataBaseConnect $db)
    {
        $this->conn = $db->getConn();
    }

    public function addPaiement(Paiement $paiement, $PaiementMethod)
    {
        try {
            $query = "INSERT INT paiement(status, order_id ) VALUES(:status,:order_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ":status" => $paiement->getStatus(),
                ":order_id" => $paiement->getCommandeId()
            ]);

            $id = $this->conn->lastInsertId();
            if ($id) {
                $query = "UPDATE paiement p JOIN orders o ON p.order_id = o.id SET p.amount = o.total_amount";
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
            } else
                echo "❌ Order created failed\n";
        } catch (PDOException $error) {
            throw new PDOException("Database error");
        }

        if ($PaiementMethod === "Card") {
            try {
                $card_number = trim(readline("Please entre the Carde Number: "));
                $query = "INSERT INT carte_bancaire(paiemrnt_id, card_number) VALUES(?,?)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindparam("is", $id, $card_number);
                $stmt->execute();
            } catch (PDOException $error) {
                throw new PDOException("Database error");
            }
        } elseif ($PaiementMethod === "Paypale") {
            
            try {
                $card_number = trim(readline("Please entre the Carde Number: "));
                $query = "INSERT INT carte_bancaire(paiemrnt_id, card_number) VALUES(?,?)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindparam("is", $id, $card_number);
                $stmt->execute();
            } catch (PDOException $error) {
                throw new PDOException("Database error");
            }
        } else {
        }
    }
}
