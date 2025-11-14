<?php
session_start();
include_once __DIR__.'/models/Usuari.php';
include_once __DIR__.'/models/UsuariDAO.php';
include_once __DIR__.'/models/utils.php';

//controla que no entre ningun usuari per URL
if(!empty($_SESSION["usuari"])){
  $_SESSION["misssatge_error"] = "No pots accedir eres usuari";
  header("Location: index.php");
  exit;
}

//Si se envia te deja entrar a este if
if($_SERVER["REQUEST_METHOD"] == "POST"){
  //Limpiar datos recibidos
  $email= neteja_dades($_POST['email']);
  $pass= neteja_dades($_POST['pass1']);
  $confirm_pass= neteja_dades($_POST['pass2']);
  //verificar que no esten vacios los campos
  if(empty($email) || empty($pass) || empty($confirm_pass)){
    $_SESSION['misssatge_error']= "Te falta algun campo por rellenar porfavor intentalo otra vez entrando a registrarse";
    header("Location: index.php");
    exit;
  }
  //verificar si ya existe email
  $hayEmail = UsuariDAO::selectByMail($email);
  if($hayEmail){
    $_SESSION['misssatge_error']= "El usuario con email:".$email." ya existe.";
    header("Location: index.php");
    exit;
  }
  if($pass !== $confirm_pass){
    $_SESSION['misssatge_error']= "La contraseña no coincide";
    header("Location: index.php");
    exit;
  }
  $usuari = new Usuari();
  $usuari->setEmail($email);
  $pass=password_hash($pass, PASSWORD_DEFAULT);
  $usuari->setPass($pass);
  UsuariDAO::insert($usuari);
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
          <!-- Correu electrònic -->
          <div class="mb-3">
            <label for="email" class="form-label">Correu electrònic</label>
            <input type="email" class="form-control" id="email"  name="email" placeholder="" required>
          </div>

          <!-- Passwd -->
          <div class="mb-3">
            <label for="password" class="form-label">Contrasenya</label>
            <input type="password" class="form-control" id="password"  name="pass1" placeholder="" required>
          </div>

          <!-- Confirmar passwd -->
          <div class="mb-3">
            <label for="confirm-password" class="form-label">Confirma la contrasenya</label>
            <input type="password" class="form-control" id="confirm-password" name="pass2" placeholder="" required>
          </div>

          <!-- Registrar-se -->
          <button type="submit" class="btn btn-primary w-100">Registra't</button>
        </form>

        <!-- Inici sessió -->
        <div class="text-center mt-3">
          <p>Ja tens un compte? <a href="login.php">Inicia sessió ací</a></p>
        </div>
      </div>
    </div>
  </div>


  <?php
include_once __DIR__ . '/footer.php';