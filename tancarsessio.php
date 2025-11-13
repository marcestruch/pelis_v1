<?php
    session_start();
    //especificar quina sessio destruir
    $_SESSION["usuari"];
    //destruirla
    session_destroy();
    //enviar a index sense sessio
    header("Location: index.php");
    exit;
?>