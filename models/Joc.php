<?php
class Joc {
    // Atributs
    private $id;
    private $titol;
    private $valoracio;
    private $pais;
    private $desenvolupador;
    private $genere;
    private $any;
    private $descripcio;
    private $imatge;

    // Constructor
    public function __construct() {
        $this->id = 0;
        $this->titol = "";
        $this->valoracio = 1;
        $this->pais = "";
        $this->desenvolupador = "";
        $this->genere = "";
        $this->any = 0;
        $this->descripcio = "";
        $this->imatge = "";
    }

    // Getters
    public function getId() { return $this->id; }
    public function getTitol() { return $this->titol; }
    public function getValoracio() { return $this->valoracio; }
    public function getPais() { return $this->pais; }
    public function getDesenvolupador() { return $this->desenvolupador; }
    public function getGenere() { return $this->genere; }
    public function getAny() { return $this->any; }
    public function getDescripcio() { return $this->descripcio; }
    public function getImatge() { return $this->imatge; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setTitol($titol) { $this->titol = $titol; }
    public function setValoracio($valoracio) {
        if ($valoracio >= 1 && $valoracio <= 5) {
            $this->valoracio = $valoracio;
        } else {
            $this->valoracio = 1;
        }
    }
    public function setPais($pais) { $this->pais = $pais; }
    public function setDesenvolupador($desenvolupador) { $this->desenvolupador = $desenvolupador; }
    public function setGenere($genere) { $this->genere = $genere; }
    public function setAny($any) { $this->any = $any; }
    public function setDescripcio($descripcio) { $this->descripcio = $descripcio; }
    public function setImatge($imatge) { $this->imatge = $imatge; }
}
?>
