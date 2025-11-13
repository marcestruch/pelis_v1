<?php
class Usuari{
    // Atributos
    private $id;
    private $email;
    private $pass;
    //Constructor
    public function __construct()
    {
        $this->id=0;
        $this->email="";
        $this->pass="";
    }
    //Getters
    
    public function getId(){
        return $this->id;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPass(){
        return $this->pass;
    }

    //Setters

    public function setId($id){
        $this->id=$id;
    }

    public function setEmail($email){
        $this->email=$email;
    }

    public function setPass($pass){
        $this->pass=$pass;
    }
}
?>