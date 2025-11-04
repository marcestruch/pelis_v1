<?php
require_once __DIR__.'/models/Peli.php';
require_once __DIR__.'/models/PeliDAO.php';
$llistaPelis = PeliDAO::getAll();
session_start();

//Comprovar

if(!empty($_SESSION["misssatge_error"])){
  $missatge_error=$_SESSION["misssatge_error"];
  $_SESSION["misssatge_error"]="";
}

include_once __DIR__ . '/header.php';
?>
<main>
  <div class="bg"
    style="background-image: 
url('assets/film.jpg'); 
      background-size: cover; 
      background-position: center; 
      height: 30vh;">
    <section class="py-5 text-center container">

      <div class="row py-lg-5">

        <div class="col-lg-6 col-md-8 mx-auto text-white">
          <h1 class="fw-light">Pelis DWES</h1>
          <p class="lead">Projecte de prova de l'alumnat de DWES.</p>
          <form method="post" action="#">
            <div class="input-group">
              <input class="form-control" type="text" name="peli_query" placeholder="Quina pel·licula estàs buscant?" aria-label="Buscar">
              <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
        </div>
      </div>

    </section>
  </div>
  <div class="album py-5 bg-light">
    <div class="container">
    <?php
    if(!empty($missatge_error)):
    ?>
  <div class="alert alert-danger" role="alert">
      <?= $missatge_error?>
  </div>
  <?php
    endif;
  ?>
    <?php if(empty($llistaPelis)): ?>
      <h2>No hi ha pelicules</h2>
      <?php endif?>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
<?php
foreach($llistaPelis as $peli):
?>
        <!-- INICI PELI -->
        <div class="col">
          <div class="card shadow-sm">
            <img class="card-img-top object-fit-cover" height="450" width="100%" src="uploads/<?= $peli->getImatge()?>" alt="Card image cap">

            <div class="card-body">
              <h5 class="card-title"><?= $peli->getTitol() ?></h5>
              <p class="card-text"><?= $peli->getSinopsi() ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted"><?= $peli->getAny()?></small>
                <div class="btn-group">
                  <a href="peliview.php?id=<?= $peli->getId()?>" class="btn btn-dark"><i class="fa fa-eye"></i></a>
                  <a href="peliedit.php" class="btn btn-danger"><i class="fa fa-pencil-square"></i></a>
                </div>


              </div>
            </div>
          </div>
        </div>

        <!-- FI PELI -->
         <?php
         endforeach
         ?>
        
</main>

<?php
include_once __DIR__ . '/footer.php';
