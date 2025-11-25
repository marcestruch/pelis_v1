<?php

require_once __DIR__ . '/Joc.php';
require_once __DIR__ . '/DBConnection.php';

class JocDAO
{
    public static function getAll(): ?array
    {
        $conn = DBConnection::connectDB();
        if (!is_null($conn)) {
            $stmt = $conn->prepare("SELECT * FROM jocs");
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Joc');
            $stmt->execute();
            return $stmt->fetchAll();
        }
        return null;
    }

    public static function select($id): ?Joc
    {
        $conn = DBConnection::connectDB();
        if (!is_null($conn)) {
            $stmt = $conn->prepare("SELECT * FROM jocs WHERE id = :id");
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Joc');
            $stmt->execute(['id' => $id]);
            $joc = $stmt->fetch();
            if ($joc) {
                return $joc;
            }
        }
        return null;
    }

    public static function insert($joc)
    {
        $conn = DBConnection::connectDB();
        if (!is_null($conn)) {
            $stmt = $conn->prepare("INSERT INTO jocs (titol, valoracio, pais, desenvolupador, genere, any, descripcio, imatge) 
                                    VALUES (:titol, :valoracio, :pais, :desenvolupador, :genere, :any, :descripcio, :imatge)");
            $stmt->execute([
                'titol' => $joc->getTitol(),
                'valoracio' => $joc->getValoracio(),
                'pais' => $joc->getPais(),
                'desenvolupador' => $joc->getDesenvolupador(),
                'genere' => $joc->getGenere(),
                'any' => $joc->getAny(),
                'descripcio' => $joc->getDescripcio(),
                'imatge' => $joc->getImatge()
            ]);
            return $conn->lastInsertId();
        }
        return 0;
    }

    public static function update($joc): int
    {
        $conn = DBConnection::connectDB();
        if (!is_null($conn)) {
            $stmt = $conn->prepare("UPDATE jocs SET 
                                    titol=:titol, 
                                    valoracio=:valoracio, 
                                    pais=:pais, 
                                    desenvolupador=:desenvolupador, 
                                    genere=:genere, 
                                    any=:any, 
                                    descripcio=:descripcio, 
                                    imatge=:imatge 
                                    WHERE id=:id");
            $stmt->execute([
                'id' => $joc->getId(),
                'titol' => $joc->getTitol(),
                'valoracio' => $joc->getValoracio(),
                'pais' => $joc->getPais(),
                'desenvolupador' => $joc->getDesenvolupador(),
                'genere' => $joc->getGenere(),
                'any' => $joc->getAny(),
                'descripcio' => $joc->getDescripcio(),
                'imatge' => $joc->getImatge()
            ]);
            return $stmt->rowCount();
        }
        return 0;
    }

    public static function delete($id): bool
    {
        $conn = DBConnection::connectDB();
        if (!is_null($conn)) {
            $stmt = $conn->prepare("DELETE FROM jocs WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return true;
        }
        return false;
    }

    public static function getSearch($query): ?array
    {
        $conn = DBConnection::connectDB();
        if (!is_null($conn)) {
            $stmt = $conn->prepare("SELECT * FROM jocs WHERE titol LIKE :query OR desenvolupador LIKE :query");
            $search = '%' . $query . '%';
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Joc');
            $stmt->execute(['query' => $search]);
            return $stmt->fetchAll();
        }
        return null;
    }
}
?>
