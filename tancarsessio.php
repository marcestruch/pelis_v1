<?php
/**
 * Tanca la sessió actual i elimina cookies.
 */
session_start();

// Elimina variables i dades de sessió.
session_unset();
session_destroy();

// Elimina la cookie de sessió del navegador.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Elimina la cookie de "usuari recordat" si existeix.
if (isset($_COOKIE["usuari_recordat"])) {
    setcookie("usuari_recordat", "", time() - 3600, "/");
}

// Redirigeix a inici.
header("Location: index.php");
exit;
?>