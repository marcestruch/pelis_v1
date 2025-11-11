
<?php
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