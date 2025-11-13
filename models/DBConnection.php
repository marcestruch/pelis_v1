<?php
class DBConnection
{
    //Database connection data
    private static $servername = "db";
    private static $dbname = "pelis2";
    private static $username = "pelis2";
    private static $password = "1234";

    public static function connectDB(): ?PDO
    {
        $servername = self::$servername;
        $dbname = self::$dbname;
        $username = self::$username;
        $password = self::$password;

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " .$e->getMessage();
            return null;
        }
    }
}