<?php
class Valoracio{
    //atributos
    private $id;
    private $peli_id;
    private $usuari_id;
    private $valoracio;
    //constructor
    public function __construct()
    {
        $this->id=0;
        $this->peli_id=0;
        $this->usuari_id=0;
        $this->valoracio=0;
    }

    //getters
    public function getId(){
        return $this->id;
    }
    public function getUsuariId(){
        return $this->usuari_id;
    }
    public function getPeliId(){
        return $this->peli_id;
    }
    public function getValoracio(){
        return $this->valoracio;
    }

    public function setId($id){
        $this->id=$id;
    }
    public function setUsuariId($usuari_id){
        $this->usuari_id=$usuari_id;
    }
    public function setPeliId($peli_id){
        $this->peli_id=$peli_id;
    }
    public function setValoracio($valoracio){
        $this->valoracio=$valoracio;
    }
}
?>