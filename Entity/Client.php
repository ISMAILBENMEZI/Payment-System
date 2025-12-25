<?php
class Client{
    private $name;
    private $email;

    public function __construct($name , $email)
    {
        $this->setName($name);
        $this->setEmail($email);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setName($name)
    {
        $name = trim($name);

        if(empty($name))
        {
            throw new InvalidArgumentException("The customer name cannot be empty");
        }

        if(strlen($name) < 3)
        {
            throw new InvalidArgumentException("Name must be at least 3 characters");
        }

        $this->name = $name;
    }


    public function setEmail($email)
    {
        if(empty(trim($email)) or !filter_var($email , FILTER_VALIDATE_EMAIL))
        {
            throw new InvalidArgumentException("Email Invqlide");
        }
        $this->email = $email;
    }

}
?>