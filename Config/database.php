<?php 
class DataBaseConnect{
    private $conn;
    private $dbhost = 'localhost';
    private $dbname = 'Payment_System';
    private $dbuser = 'root';
    private $dbpass = '';

    public function __construct()
    {
        try{
          $this->conn = new PDO("mysql:host={$this->dbhost};dbname={$this->dbname};charset=utf8",$this->dbuser,$this->dbpass); 
          $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $error){
            die("Database connection failed");
        }
    }

    public function getConn()
    {
        return $this->conn;
    }
}
?>