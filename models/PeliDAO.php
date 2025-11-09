<?php

require_once __DIR__ . '/Peli.php';
require_once __DIR__ . '/DBConnection.php';
require_once __DIR__ . '/IDbAccess.php';

//class PeliDao implements IDbAccess
class PeliDAO
{
    public static function getAll(): ?array
    {
        $conn = DBConnection::connectDB();
        if (!is_null($conn)) {
            $stmt = $conn->prepare("SELECT id, 
                                           titol,
                                           valoracio,
                                           pais,
                                           director,
                                           genere,
                                           duracio,
                                           anyo,
                                           sinopsi,
                                           imatge
                                     FROM pelis");
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Peli');
            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            return null;
        }
    }
    public static function select($id): ?Peli
    {
        $conn = DBConnection::connectDB();
        if (!is_null($conn)) {
            $stmt = $conn->prepare("SELECT id, 
                                           titol,
                                           valoracio,
                                           pais,
                                           director,
                                           genere,
                                           duracio,
                                           anyo,
                                           sinopsi,
                                           imatge
                                     FROM pelis
                                     WHERE id = :id");
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Peli');
            $stmt->execute(['id'=>$id]);
            $peli = $stmt->fetch();
            if($peli){
                return $peli;
            }
        }
        return null;
    }

    public static function update($object): int
    {
        $conn = DBConnection::connectDB();
        if (!is_null($conn)) {
            $stmt = $conn->prepare("UPDATE pelis
                                    SET titol=:titol,
                                    valoracio=:valoracio,
                                    pais=:pais,
                                    director=:director,
                                    genere=:genere,
                                    duracio=:duracio,
                                    anyo=:anyo
                                    sinopsi=:sinopsi,
                                    imatge=:imatge
                                    WHERE id=:id");
            $stmt->execute(['id' =>$object->getId(),
                            'titol' => $object -> getTitol(),
                            'valoracio' => $object -> getValoracio(),
                            'pais' => $object -> getPais(),
                            'director' => $object -> getDirector(),
                            'genere' => $object -> getGenere(),
                            'duracio' => $object -> getDuracio(),
                            'anyo' => $object -> getAny(),
                            'sinopsi' => $object -> getSinopsi(),
                            'imatge' => $object -> getImatge()]);
            return $stmt->rowCount();
        }
        return 0;
    }
}

?>