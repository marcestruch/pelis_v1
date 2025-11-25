<?php
/**
 * Pàgina per eliminar una pel·lícula per id. Només per usuaris registrats.
 */
require_once __DIR__ . '/../models/PeliDAO.php';
session_start();

// Bloqueja l'accés si no eres usuari actiu.
if(empty($_SESSION["usuari"])){
    $_SESSION["misssatge_error"] = "No pots accedir, no eres usuari";
    header("Location: index.php");
    exit;
}

// Comprova si hi ha l'id, sinó mostra error.
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

// Elimina la pel·lícula i mostra resultat.
if (PeliDAO::delete($id)) {
    $_SESSION['misssatge_error'] = "Pel·lícula eliminada correctament.";
} else {
    $_SESSION['misssatge_error'] = "Error en eliminar la pel·lícula.";
}

header("Location: index.php");
exit();
?>
