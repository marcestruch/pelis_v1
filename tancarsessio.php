<?php
// 1. Iniciar la sesión (obligatorio para trabajar con $_SESSION o session_destroy()).
session_start();

// 2. Destruir la sesión en el servidor.
// session_unset() borra las variables del array $_SESSION.
session_unset(); 
// session_destroy() destruye los datos de la sesión en el almacenamiento del servidor.
session_destroy();

// 3. Eliminar la cookie de sesión del navegador (PHPSESSID por defecto).
// Se obtienen los parámetros originales para asegurar la eliminación correcta.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Eliminar la cookie de "recordar usuario" específica (si existe).
if (isset($_COOKIE["usuari_recordat"])) {
    // Destruye la cookie configurando su tiempo de expiración en el pasado.
    // Asegúrate de usar la misma ruta ("/") si es necesario.
    setcookie("usuari_recordat", "", time() - 3600, "/"); 
}

// 5. Redirigir al usuario a la página de inicio.
header("Location: index.php");
exit; // Terminar el script para asegurar la redirección inmediata.
?>