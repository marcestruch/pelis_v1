<?php

require_once __DIR__ . '/Peli.php';
require_once __DIR__ . '/DBConnection.php';
require_once __DIR__ . '/IDbAccess.php';

class UsuariDAO{
    public static function selectByMail($email): ?Usuari
    {
        $conn = DBConnection::connectDB();
        if (!is_null($conn)) {
            $stmt = $conn->prepare("SELECT id, 
                                           email,
                                           pass
                                     FROM usuaris
                                     WHERE email = :email");
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Peli');
            $stmt->execute(['email'=>$email]);
            $peli = $stmt->fetch();
            if($peli){
                return $peli;
            }
        }
        return null;
    }
}
?>