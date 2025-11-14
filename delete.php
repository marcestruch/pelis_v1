<?php
require_once __DIR__ . '/models/PeliDAO.php';
session_start();
//controla que el no entre ningun no usuari en una id afegida per URL
if(empty($_SESSION["usuari"])){
  $_SESSION["misssatge_error"] = "No pots accedir no eres usuari";
  header("Location: index.php");
  exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['misssatge_error'] = "ID invàlid per eliminar la pel·lícula.";
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);
$peliExisteix = PeliDAO::select($id);

if (!$peliExisteix) {
    $_SESSION['misssatge_error'] = "La pel·lícula amb ID $id no existeix.";
    header("Location: index.php");
    exit();
}

if (PeliDAO::delete($id)) {
    $_SESSION['misssatge_error'] = "Pel·lícula eliminada correctament.";
} else {
    $_SESSION['misssatge_error'] = "Error en eliminar la pel·lícula.";
}

header("Location: index.php");
exit();
?>
