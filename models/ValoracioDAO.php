<?php
require_once __DIR__. '/Valoracio.php';
require_once __DIR__. '/DBConnection.php';
require_once __DIR__. '/IDbAccess.php';

class ValoracioDAO{
    public static function selectByUserPeliId($usuari_id, $peli_id): ?Valoracio
    {
        $conn= DBConnection::connectDB();
        if(!is_null($conn)){
            $stmt = $conn->prepare("SELECT id, peli_id, joc_id, usuari_id, valoracio
                                    FROM valoracions
                                    WHERE usuari_id = :usuari_id
                                    AND peli_id = :peli_id");
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Valoracio');
            $stmt->execute(['usuari_id'=>$usuari_id,
                            'peli_id'=>$peli_id]);
            $valoracio = $stmt->fetch(); 
            if($valoracio){
                return $valoracio;
            }else{
                return null;
            }
        }
        return null;
    }

    public static function selectByUserJocId($usuari_id, $joc_id): ?Valoracio
    {
        $conn= DBConnection::connectDB();
        if(!is_null($conn)){
            $stmt = $conn->prepare("SELECT id, peli_id, joc_id, usuari_id, valoracio
                                    FROM valoracions
                                    WHERE usuari_id = :usuari_id
                                    AND joc_id = :joc_id");
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Valoracio');
            $stmt->execute(['usuari_id'=>$usuari_id,
                            'joc_id'=>$joc_id]);
            $valoracio = $stmt->fetch(); 
            if($valoracio){
                return $valoracio;
            }else{
                return null;
            }
        }
        return null;
    }
    
    public static function insertarValoracio($valoracio)
    {
        $conn = DBConnection::connectDB();
        if(!is_null($conn)){
            $peli_id = $valoracio->getPeliId() ?: null;
            $joc_id = $valoracio->getJocId() ?: null;

            $stmt = $conn->prepare("INSERT INTO valoracions(id, peli_id, joc_id, usuari_id, valoracio) VALUES (null, :peli_id, :joc_id, :usuari_id, :valoracio)");
            $stmt->execute([
                'peli_id'=>$peli_id,
                'joc_id'=>$joc_id,
                'usuari_id'=>$valoracio->getUsuariId(),
                'valoracio'=>$valoracio->getValoracio()
            ]);
            return $conn->lastInsertId();
        }
        return 0;
    }

    // Devuelve objeto con la media obteniendo el id de la pelicula
    public static function selectMediaByPeliId($peli_id)
    {
        $conn= DBConnection::connectDB();
        if(!is_null($conn)){
            $stmt = $conn->prepare("SELECT AVG(valoracio)
                                    FROM valoracions
                                    WHERE peli_id = :peli_id");
            $stmt->execute(['peli_id'=>$peli_id]);
            return $stmt->fetch()[0];    
        }
        return null;
    }

    public static function selectMediaByJocId($joc_id)
    {
        $conn= DBConnection::connectDB();
        if(!is_null($conn)){
            $stmt = $conn->prepare("SELECT AVG(valoracio)
                                    FROM valoracions
                                    WHERE joc_id = :joc_id");
            $stmt->execute(['joc_id'=>$joc_id]);
            return $stmt->fetch()[0];    
        }
        return null;
    }
}
?>