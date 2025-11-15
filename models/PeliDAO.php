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
                                    anyo=:anyo,
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
    public static function insert($peli)
    {
        $conn = DBConnection::connectDB();
        if (!is_null($conn)) {
            $stmt = $conn->prepare("INSERT INTO pelis(id,  
                                           titol,
                                           valoracio,
                                           pais,
                                           director,
                                           genere,
                                           duracio,
                                           anyo,
                                           sinopsi,
                                           imatge)   
                                     VALUES(:id,  
                                           :titol,
                                           :valoracio,
                                           :pais,
                                           :director,
                                           :genere,
                                           :duracio,
                                           :anyo,
                                           :sinopsi,
                                           :imatge)");
            $stmt->execute([
                'id' => null,
                'titol' => $peli->getTitol(),
                'valoracio' => $peli->getValoracio(),
                'pais' => $peli->getPais(),
                'director' => $peli->getDirector(),
                'genere' => $peli->getGenere(),
                'duracio' => $peli->getDuracio(),
                'anyo' => $peli->getAny(),
                'sinopsi' => $peli->getSinopsi(),
                'imatge' => $peli->getImatge()
            ]);
            return $conn->lastInsertId();
        }
        return 0;
    }
    public static function delete($id): bool
    {
    $conn = DBConnection::connectDB();
    if (!is_null($conn)) {
        // Comprobar si existe
        $stmt = $conn->prepare("SELECT id FROM pelis WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $peli = $stmt->fetch();

        if (!$peli) {
            // No existe la película
            return false;
        }

        // Si existe, eliminarla
        $stmt = $conn->prepare("DELETE FROM pelis WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return true;
    }
    return false;
}
public static function getSearch($peli_buscada): ?array
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
                                     WHERE titol LIKE :query OR director LIKE :query");
            $search = '%' . $peli_buscada . '%';
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Peli');
            $stmt->execute(['query' => $search]);
            return $stmt->fetchAll();
        } else {
            return null;
        }
    }
public static function getByGenere($genere): ?array
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
                                 WHERE genere LIKE :genere");
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Peli');
        $search_genere = '%' . $genere . '%';
        $stmt->execute(['genere' => $search_genere]);
        return $stmt->fetchAll();
    }
    return null;
}
}


?>