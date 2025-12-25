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
            } else {
                throw new InvalidArgumentException("This user already exists");
            }
        } catch (PDOException $error) {
            throw new PDOException("Database error");
        }
    }

    public function getAllClients(){
        try{
            $sql = "SELECT * FROM customer";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $client = [];

            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $client[]=new Client($row['name'] , $row['email']);
            }
            return $client;
            
        }catch(PDOException $error)
        {
            throw new PDOException("Database error");
        }
    }
}
