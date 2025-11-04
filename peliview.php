<?php
require_once __DIR__.'/models/Peli.php';
require_once __DIR__.'/models/PeliDAO.php';session_start();


include_once __DIR__.'/models/utils.php';

$peli = null;
if ($_SERVER['REQUEST_METHOD'] == "GET") {
  if(isset($_GET["id"]) && !empty($_GET["id"])){
    $id = neteja_dades($_GET["id"]);
    $peli = PeliDAO::select($id);
  }
}

    if(empty($peli)){
      $_SESSION["misssatge_error"]="No sha trobat pelicula";
      header('Location: index.php');
      exit;
    }
include_once __DIR__ . '/header.php';
?>
<main>
  
<?php    
    if(!empty($peli)):
  ?>
  <!-- imatge de capçalera-->
  <div class="bg"
    style="background-image: 
    url('uploads/<?= $peli->getImatge()?>'); 
      background-size: cover; 
      background-position: center; 
      height: 30vh;">
    <section class="py-5 text-center container">

      <div class="row py-lg-5">
        <!-- títol de la pàgina -->
        <div class="col-lg-6 col-md-8 mx-auto text-white">
          <h1 class="fw-light"><?= $peli->getTitol()?></h1>
          <p class="lead"><?= $peli->getDirector()?> - <?= $peli->getAny()?></p>
        </div>
      </div>

    </section>
  </div>
  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row mb-2">
        <div class="col-md-12">
          <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col-md-4 d-none d-lg-block">
              <img src="uploads/<?= $peli->getImatge()?>" class="object-fit-cover" alt="portada_peli" height="450" width="100%">

            </div>
            <!-- Dades de la pel·li-->
            <div class="col p-4 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-primary"><?= $peli->getDirector()?> - <?= $peli->getAny()?> - <?= $peli->getPais()?> - <?= $peli->getDuracio()?></strong>
              <h1 class="d-inline-flex justify-content-between align-items-center">
                <?= $peli->getTitol()?>
                <!-- Puntuació-->
                <span class="ms-3">
                  <i class="bi bi-star-fill fs-5"></i>
                  <i class="bi bi-star-fill fs-5"></i>
                  <i class="bi bi-star-fill fs-5"></i>
                  <i class="bi bi-star-fill fs-5"></i>
                  <i class="bi bi-star fs-5"></i>
                </span>
              </h1>
              <!-- Argument-->
              <p class="card-text mb-auto"><?= $peli -> getSinopsi()?></p>

              <!-- Gèneres-->
              <p class="mb-2 text-end">
                <a href="#" class="btn btn-primary">Thriller</a>
                <a href="#" class="btn btn-primary">Drama</a>
                <a href="#" class="btn btn-primary">Crimen</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
      <?php
      endif;
      ?>
</main>
<?php
include_once __DIR__ . '/footer.php';
