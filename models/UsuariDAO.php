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
            $usuari = $stmt->fetch();
            if($usuari){
                return $usuari;
            }
        }
        return null;
    }
    public static function insert($usuari)
    {
        $conn = DBConnection::connectDB();
        if (!is_null($conn)) {
            $stmt = $conn->prepare("INSERT INTO usuaris(id,  
                                          email,
                                          pass)
                                     VALUES(:id,  
                                            :email,
                                            :pass)");
            $stmt->execute([
                'id' => null,
                'email' => $usuari::getEmail(),
                'pass' => $usuari::getPass()
            ]);
            return $conn->lastInsertId();
        }
        return 0;
    }
}
?>