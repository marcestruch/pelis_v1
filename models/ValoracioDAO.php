<?php
require_once __DIR__. '/Valoracio.php';
require_once __DIR__. '/DBConnection.php';
require_once __DIR__. '/IDbAccess.php';

class ValoracioDAO{
    public static function selectByUserPeliId($usuari_id, $peli_id): ?Valoracio
    {
        $conn= DBConnection::connectDB();
        if(!is_null($conn)){
            $stmt = $conn->prepare("SELECT id, peli_id, usuari_id, valoracio
                                    FROM valoracions
                                    WHERE usuari_id = :usuari_id
                                    AND peli_id = :peli_id");
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Valoracio');
            $stmt->execute(['usuari_id'=>$usuari_id,
                            'peli_id'=>$peli_id]);
            $valoracio = $stmt->fetch(); 
            if($valoracio){
                return $valoracio;
            }    
        }
        return null;
    }
}
?>