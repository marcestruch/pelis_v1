<?php
class Peli{
    // Atributos
    private $id;
    private $titol;
    private $valoracio;
    private $pais;
    private $director;
    private $genere;
    private $duracio;
    private $anyo;
    private $sinopsi;
    private $imatge;
    //Constructor
    public function __construct()
    {
        $this->id=0;
        $this->titol="";
        $this->valoracio= 1;
        $this-> pais= "";
        $this->director= "";
        $this->genere= "";
        $this->duracio= 0;
        $this->anyo= 0;
        $this->sinopsi= "";
        $this->imatge= "";
    }
    //getters
    public function getId(){
        return $this->id;
    }

    public function getTitol(){
        return $this->titol;
    }
    
    public function getValoracio(){
        return $this->valoracio;
    }
    
    public function getPais(){
        return $this->pais;
    }
    
    public function getDirector(){
        return $this->director;
    }

    public function getGenere(){
        return $this->genere;
    }

    public function getDuracio(){
        return $this->duracio;
    }

    public function getAny(){
        return $this->anyo;
    }

    public function getSinopsi(){
        return $this->sinopsi;
    }
    
    public function getImatge(){
        return $this->imatge;
    }
    
    //Setters
    public function setId($id){
        $this->id=$id;
    }

    public function setTitol($titol){
        $this->titol=$titol;
    }
    
    public function setValoracio($valoracio){
        if($valoracio>=1 && $valoracio<=5){
        $this->valoracio=$valoracio;
        }else{
            $this->valoracio=1;
        }
    }
    
    public function setPais($pais){
        $this->pais=$pais;
    }
    
    public function setDirector($director){
        $this->director=$director;
    }

    public function setGenere($genere){
        $this->genere=$genere;
    }

    public function setDuracio($duracio){
        $this->duracio=$duracio;
    }

    public function setAny($anyo){
        $this->anyo=$anyo;
    }

    public function setSinopsi($sinopsi){
        $this->sinopsi=$sinopsi;
    }
    
    public function setImatge($imatge){
        $this->imatge=$imatge;
    }
}
?>