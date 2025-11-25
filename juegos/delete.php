<?php
/**
 * Pàgina per eliminar un joc per id. Només per usuaris registrats.
 */
require_once __DIR__ . '/../models/JocDAO.php';
session_start();

// Bloqueja l'accés si no eres usuari actiu.
if(empty($_SESSION["usuari"])){
    $_SESSION["misssatge_error"] = "No pots accedir, no eres usuari";
    header("Location: index.php");
    exit;
}

// Comprova si hi ha l'id, sinó mostra error.
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['misssatge_error'] = "ID invàlid per eliminar el joc.";
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);
$jocExisteix = JocDAO::select($id);

if (!$jocExisteix) {
    $_SESSION['misssatge_error'] = "El joc amb ID $id no existeix.";
    header("Location: index.php");
    exit();
}

// Elimina el joc i mostra resultat.
if (JocDAO::delete($id)) {
    $_SESSION['misssatge_error'] = "Joc eliminat correctament.";
} else {
    $_SESSION['misssatge_error'] = "Error en eliminar el joc.";
}

header("Location: index.php");
exit();
?>
