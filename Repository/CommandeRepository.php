<?php
include_once "./Entity/Commande.php";

class CommandeRepository
{
    private $conn;

    public function __construct(DataBaseConnect $db)
    {
        $this->conn = $db->getConn();
    }

    public function addCommande(Commande $commande)
    {
        try {
            $query = "INSERT INTO orders(total_amount , status , customert_id) VALUES (:total_amount , :status , :customert_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ":total_amount" => $commande->getMontantTotal(),
                ":status" => $commande->getStatus(),
                ":customert_id" => $commande->getClientId()
            ]);
            $id = $this->conn->lastInsertId();
            if ($id)
                echo "✅ Order created successfully\n";
            else
                echo "❌ Order created failed\n";
        } catch (PDOException $error) {
            throw new PDOException("Database error");
        }
    }

    public function getCommandeById($ClientId)
    {
        try {
            $query = "SELECT * FROM orders where customert_id = :ClientId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindparam(":ClientId", $ClientId);
            $stmt->execute();

            $result = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $C = new Commande($row['total_amount'], $row['customert_id'], $row['status']);
                $C->setId($row['id']);
                $result[] = $C;
            }

            return $result;
        } catch (PDOException $error) {
            throw new PDOException("Database error");
        }
    }

    public function getAllCommande()
    {
        try {
            $query = "SELECT * FROM orders where 1=1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $result = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $C = new Commande($row['total_amount'], $row['customert_id'], $row['status']);
                $C->setId($row['id']);
                $result[] = $C;
            }

            return $result;
        } catch (PDOException $error) {
            throw new PDOException("Database error");
        }
    }

    public function CancelCommande($CommandeId)
    {
        try {
            $query = "UPDATE orders set status = 'CANCELLED' where id = :CommandeId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindparam(":CommandeId", $CommandeId);
            $stmt->execute();
        } catch (PDOException $error) {
            throw new PDOException("Database error");
        }
    }
}
