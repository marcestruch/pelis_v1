<?php
/**
 * Pàgina per registrar nous usuaris.
 */
session_start();
include_once __DIR__.'/models/Usuari.php';
include_once __DIR__.'/models/UsuariDAO.php';
include_once __DIR__.'/models/utils.php';

// Control de l'usuari actiu.
if(!empty($_SESSION["usuari"]) || !empty($_COOKIE['usuari_recordat'])){
    $usuariActiu = true;
    $nom = $_SESSION["usuari"] ?? $_COOKIE['usuari_recordat'];
} else {
    $usuariActiu = false;
    $nom = "Guest";
}

// Bloqueja la pàgina a usuaris ja connectats.
if(!empty($_SESSION["usuari"])){
    $_SESSION["misssatge_error"] = "No pots accedir eres usuari";
    header("Location: index.php");
    exit;
}

// Registre (POST)
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Neteja dades rebudes.
    $email = neteja_dades($_POST['email'] ?? '');
    $pass = neteja_dades($_POST['pass1'] ?? '');
    $confirm_pass = neteja_dades($_POST['pass2'] ?? '');

    // Comprova camps
    if(empty($email) || empty($pass) || empty($confirm_pass)){
        $_SESSION['misssatge_error'] = "Te falta algun camp per omplir. Intenta-ho una altra vegada!";
        header("Location: index.php");
        exit;
    }
    // Comprova si email ja està registrat.
    $hayEmail = UsuariDAO::selectByMail($email);
    if($hayEmail){
        $_SESSION['misssatge_error'] = "El usuari amb email: $email ja existeix.";
        header("Location: index.php");
        exit;
    }
    // Comprova si la contrasenya és igual.
    if($pass !== $confirm_pass){
        $_SESSION['misssatge_error'] = "La contrasenya no coincideix";
        header("Location: index.php");
        exit;
    }
    // Registra l'usuari nou (hash contrasenya).
    $usuari = new Usuari();
    $usuari->setEmail($email);
    $usuari->setPass(password_hash($pass, PASSWORD_DEFAULT));
    UsuariDAO::insert($usuari);
    $_SESSION['misssatge_error']="";
    $_SESSION['missatge_ok'] = "Compte creat correctament! Ja pots iniciar sessió.";
    header("Location: login.php");
    exit;
}

include_once __DIR__ . '/header.php';
?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card" style="width: 26rem;">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">Crear un compte</h5>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="email" class="form-label">Correu electrònic</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contrasenya</label>
                    <input type="password" class="form-control" id="password" name="pass1" required>
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirma la contrasenya</label>
                    <input type="password" class="form-control" id="confirm-password" name="pass2" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Registra't</button>
            </form>
            <div class="text-center mt-3">
                <p>Ja tens un compte? <a href="login.php">Inicia sessió ací</a></p>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/footer.php'; ?>