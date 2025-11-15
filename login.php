<?php
session_start();
include_once __DIR__.'/models/Usuari.php';
include_once __DIR__.'/models/UsuariDAO.php';
include_once __DIR__.'/models/utils.php';

//controlar el flujo de session
if(!empty($_SESSION["usuari"]) || !empty($_COOKIE['usuari_recordat'])){
  $usuariActiu=true;
  $nom = $_SESSION["usuari"] ?? $_COOKIE['usuari_recordat'];
}else{
  //si no
  $usuariActiu=false;
  $nom = "Guest";
}
//controla que no entre ningun usuari per URL
if(!empty($_SESSION["usuari"])){
  $_SESSION["misssatge_error"] = "No pots accedir eres usuari";
  header("Location: index.php");
  exit;
}
// Si arriba d'un registre correcte, mostra el missatge d'èxit!
$missatge_ok = "";
if (!empty($_SESSION['missatge_ok'])) {
    $missatge_ok = $_SESSION['missatge_ok'];
    $_SESSION['missatge_ok'] = "";
}

$missatge_error = "";
if (!empty($_SESSION['misssatge_error'])) {
    $missatge_error = $_SESSION['misssatge_error'];
    $_SESSION['misssatge_error'] = "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = neteja_dades($_POST['usuari']);
    $pass = neteja_dades($_POST['password']);

    if (empty($email) || empty($pass)) {
        $_SESSION['misssatge_error'] = "Cal completar tots els camps.";
        header("Location: login.php");
        exit;
    }

    $usuari = UsuariDAO::selectByMail($email);
    if (!$usuari) {
        $_SESSION['misssatge_error'] = "No s'ha trobat cap usuari amb aquest email.";
        header("Location: login.php");
        exit;
    }

    if (!password_verify($pass, $usuari->getPass())) {
        $_SESSION['misssatge_error'] = "La contrasenya no és correcta.";
        header("Location: login.php");
        exit;
    }

    // Si arriba aquí: login correcte
    $_SESSION['usuari'] = $usuari->getEmail();

    // Recordar (cookie 30 dies)
    if (!empty($_POST['recordar'])) {
        setcookie("usuari_recordat", $usuari->getEmail(), time() + (30 * 24 * 60 * 60), "/");
    } else {
        setcookie("usuari_recordat", "", time() - 3600, "/");
    }

    header("Location: index.php");
    exit;
}
include_once __DIR__ . '/header.php';
?>

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card" style="width: 24rem;">
      <div class="card-body">
        <h5 class="card-title text-center mb-4">Iniciar Sessió</h5>
        <?php if ($missatge_error): ?>
          <div class="alert alert-danger" role="alert"><?= $missatge_error ?></div>
        <?php endif; ?>
        <?php if ($missatge_ok): ?>
          <div class="alert alert-success" role="alert"><?= $missatge_ok ?></div>
        <?php endif; ?>
        <form action="#" method="post">
          <!-- Usuari -->
          <div class="mb-3">
            <label for="usuari" class="form-label">Usuari</label>
            <input type="text" class="form-control" id="usuari" name="usuari" placeholder="" required>
          </div>

          <!-- Contrasenya -->
          <div class="mb-3">
            <label for="password" class="form-label">Contrasenya</label>
            <input type="password" class="form-control" id="password"  name="password" placeholder="" required>
          </div>

          <!-- Recordar -->
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="recordar" name="recordar" <?= isset($_COOKIE["usuari_recordat"]) ? "checked" : "" ?>>
            <label class="form-check-label" for="recordar">Recorda'm</label>
          </div>

          <!-- Botó Inici de Sessió -->
          <button type="submit" class="btn btn-primary w-100">Iniciar Sessió</button>
        </form>

        <!-- Registre -->
        <div class="text-center mt-3">
          <p>No tens compte? <a href="registre.php">Registra't ací</a></p>
        </div>
      </div>
    </div>
  </div>


<?php
include_once __DIR__ . '/footer.php';