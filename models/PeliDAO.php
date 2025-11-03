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
}

?>