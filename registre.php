
<?php
include_once __DIR__.'/models/Usuari.php';
include_once __DIR__.'/models/UsuariDAO.php';
include_once __DIR__.'/models/utils.php';
//Si se envia te deja entrar a este if
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
//Limpiar datos recibidos
$email= neteja_dades($_POST['email']);
$pass= neteja_dades($_POST['pass']);
  //verificar que no esten vacios los campos
  if(empty($email) || empty($pass)){
    $_SESSION['misssatge_error']= "Te falta algun campo por rellenar porfavor intentalo otra vez entrando a registrarse";
    header("Location: index.php");
    exit;
  }
  //verificar si ya existe email
  if($email == UsuariDAO::selectByMail($email)){
    $_SESSION['misssatge_error']= "El usuario con email:".$email." ya existe.";
    header("Location: index.php");
    exit;
  }
  
}


include_once __DIR__ . '/header.php';
?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card" style="width: 26rem;">
      <div class="card-body">
        <h5 class="card-title text-center mb-4">Crear un compte</h5>
        <form action="#" mehod="post">
          <!-- Correu electrònic -->
          <div class="mb-3">
            <label for="email" class="form-label">Correu electrònic</label>
            <input type="email" class="form-control" id="email"  name="email" placeholder="" required>
          </div>

          <!-- Passwd -->
          <div class="mb-3">
            <label for="password" class="form-label">Contrasenya</label>
            <input type="password" class="form-control" id="password"  name="confirm-password" placeholder="" required>
          </div>

          <!-- Confirmar passwd -->
          <div class="mb-3">
            <label for="confirm-password" class="form-label">Confirma la contrasenya</label>
            <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="" required>
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