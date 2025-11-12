<?php
session_start();
include_once __DIR__.'/models/Usuari.php';
include_once __DIR__.'/models/UsuariDAO.php';
include_once __DIR__.'/models/utils.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
  //Limpiar datos recibidos
  $email= neteja_dades($_POST['email']);
  $pass= neteja_dades($_POST['pass1']);
  //verificar que no esten vacios los campos
  if(empty($email) || empty($pass)){
    $_SESSION['misssatge_error']= "Te falta algun campo por rellenar porfavor intentalo otra vez entrando a registrarse";
    header("Location: index.php");
    exit;
  }
  //verificar si no existe email
  $hayEmail = UsuariDAO::selectByMail($email);
  if(!$hayEmail){
    $_SESSION['misssatge_error']= "El usuario con email:".$email." no existe.";
    header("Location: index.php");
    exit;
  }
}
include_once __DIR__ . '/header.php';
?>

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card" style="width: 24rem;">
      <div class="card-body">
        <h5 class="card-title text-center mb-4">Iniciar Sessió</h5>
        <?php
          if(!empty($missatge_error)):
        ?>
          <div class="alert alert-danger" role="alert">
            <?= $missatge_error?>
          </div>
        <?php
          endif;
        ?>
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
            <input type="checkbox" class="form-check-input" id="recordar">
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