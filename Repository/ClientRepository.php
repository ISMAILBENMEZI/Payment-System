<?php
include_once './Entity/Client.php';

class ClientRepository
{
    private $conn;

    public function __construct(DataBaseConnect $db)
    {
        $this->conn = $db->getConn();
    }

    public function addClient(Client $client)
    {
        try {
            $sql = "SELECT COUNT(*) FROM customer where email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $client->getEmail()]);

            $customer = $stmt->fetchColumn();
            if ($customer == 0) {
                $sql = "INSERT INTO customer (name , email) Values(:name, :email)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':name' => $client->getName(),
                    ':email' => $client->getEmail()
                ]);

                $id = $this->conn->lastInsertId();
                if ($id)
                    echo "✅ Customer created successfully\n";
                else
                    echo "❌ Customer created failed\n";
            } else {
                throw new InvalidArgumentException("This user already exists");
            }
        } catch (PDOException $error) {
            throw new PDOException("Database error");
        }
    }

    public function getClientsByName($clientName)
    {
        try {
            $sql = "SELECT * FROM customer WHERE name LIKE :name";
            $stmt = $this->conn->prepare($sql);
            $searchName = "%" . $clientName . "%";
            $stmt->bindparam(":name", $searchName, PDO::PARAM_STR);
            $stmt->execute();
            $client = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $c = new Client($row['name'], $row['email']);
                $c->setId($row['id']);
                $client[] = $c;
            }
            return $client;
        } catch (PDOException $error) {
            throw new PDOException("Database error");
        }
    }

    public function getAllClients()
    {
        try {
            $sql = "SELECT * FROM customer";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $client = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $c = new Client($row['name'], $row['email']);
                $c->setId($row['id']);
                $client[] = $c;
            }
            return $client;
        } catch (PDOException $error) {
            throw new PDOException("Database error");
        }
    }
}
