<?php
require_once __DIR__ . '/models/PeliDAO.php';
session_start();

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
