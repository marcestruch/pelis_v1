<?php
include_once __DIR__.'/models/PeliDAO.php';
include_once __DIR__.'/models/Peli.php';
include_once __DIR__.'/models/utils.php';
session_start();

// Inicializar variables
$id = "";
$imatge_cap = "assets/film.jpg";
$titol_pagina = "Nova pel·lícula";
$titol = "";
$director = "";
$imatge_portada = "assets/proximamente.png";
$valoracio = 1;
$generes = "";
$llista_generes_peli = [];
$pais = "";
$duracio = 100;
$anyo = date("Y");
$sinopsi = "";

$is_insertat = false;
$is_actualitzat = false;

// Inicializar listas select
$llista_paisos_select = [
  'Espanya',
  'Estats Units',
  'Itàlia',
  'Japó',
  'Regne Unit'
];

$llista_generes_select = [
  'Acció',
  'Ciència-ficció',
  'Comèdia',
  'Drama',
  'Fantasia',
  'Història',
  'Terror'
];
if(!empty($_SESSION["usuari"]) || !empty($_COOKIE['usuari_recordat'])){
  $usuariActiu=true;
  $nom = $_SESSION["usuari"] ?? $_COOKIE['usuari_recordat'];
}else{
  //si no
  $usuariActiu=false;
  $nom = "Guest";
}
//no deixar que entre per URL
if(empty($_SESSION["usuari"])){
  $_SESSION["misssatge_error"] = "No pots accedir no eres usuari";
  header("Location: index.php");
  exit;
}

// --- CASO GET: Cargar datos si hay ID ---
if ($_SERVER['REQUEST_METHOD'] == "GET") {
  if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = neteja_dades($_GET["id"]);

    // Comprobar si existe la película
    $peli = PeliDAO::select($id);

    if (!$peli) {
      // Si no existe, redirigir con mensaje de error
      $_SESSION["misssatge_error"] = "La pel·lícula amb ID $id no existeix.";
      header("Location: index.php");
      exit;
    }

    // Si existe, cargar datos
    $imatge_cap = (!empty($peli->getImatge())) ? "uploads/" . $peli->getImatge() : "assets/film.jpg";
    $titol = $peli->getTitol();
    $titol_pagina = $titol;
    $imatge_portada = (!empty($peli->getImatge())) ? "uploads/" . $peli->getImatge() : "assets/proximamente.png";
    $valoracio = $peli->getValoracio();
    $director = $peli->getDirector();
    $generes = $peli->getGenere();
    $llista_generes_peli = explode(",", $generes);
    $pais = $peli->getPais();
    $duracio = $peli->getDuracio();
    $anyo = $peli->getAny();
    $sinopsi = $peli->getSinopsi();
  }
}

// --- CASO POST: Insertar o actualizar película ---
if (isset($_POST['formulari'])) {
  $id = neteja_dades($_POST["id"]);
  $titol = neteja_dades($_POST["titol"]);
  $valoracio = neteja_dades($_POST["valoracio"]);
  $director = neteja_dades($_POST["director"]);
  $pais = neteja_dades($_POST["pais"]);
  $generes = neteja_dades(implode(",", $_POST["genere"] ?? []));
  $duracio = neteja_dades($_POST["duracio"]);
  $anyo = neteja_dades($_POST["any"]);
  $sinopsi = neteja_dades($_POST["sinopsi"]);

  // Subida de imagen
  $imatge_nova = "";
  if (isset($_FILES['imatge_portada']) && $_FILES['imatge_portada']['error'] == 0) {
    $imatge_nova = pujar_imatge("imatge_portada", $titol);
  }

  // --- Insertar nueva película ---
  if (empty($id)) {
    $peli = new Peli();
    $peli->setTitol($titol);
    $peli->setDirector($director);
    $peli->setValoracio($valoracio);
    $peli->setGenere($generes);
    $peli->setPais($pais);
    $peli->setDuracio($duracio);
    $peli->setAny($anyo);
    $peli->setSinopsi($sinopsi);
    if (!empty($imatge_nova)) {
      $peli->setImatge($imatge_nova);
    }

    $id = PeliDAO::insert($peli);
    $peli->setId($id);
    $is_insertat = true;
  }
  // --- Actualizar película existente ---
  else {
    $peli = PeliDAO::select($id);

    if (!$peli) {
      $_SESSION["misssatge_error"] = "No s'ha pogut actualitzar: la pel·lícula no existeix.";
      header("Location: index.php");
      exit;
    }

    $peli->setTitol($titol);
    $peli->setDirector($director);
    $peli->setValoracio($valoracio);
    $peli->setGenere($generes);
    $peli->setPais($pais);
    $peli->setDuracio($duracio);
    $peli->setAny($anyo);
    $peli->setSinopsi($sinopsi);
    if (!empty($imatge_nova)) {
      $peli->setImatge($imatge_nova);
    }

    PeliDAO::update($peli);
    $is_actualitzat = true;
  }

  // Actualizar imágenes y página
  if (!empty($peli->getImatge())) {
    $imatge_cap = './uploads/' . $peli->getImatge();
    $imatge_portada = './uploads/' . $peli->getImatge();
  }

  $llista_generes_peli = explode(",", $peli->getGenere());
  $titol_pagina = $titol;
}

include_once __DIR__ . '/header.php';
?>

<main>
  <div class="bg"
    style="background-image:url('<?= $imatge_cap ?>');
      background-size:cover;
      background-position:center;
      height:30vh;">
    <section class="py-5 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto text-white">
          <h1 class="fw-light"><?= $titol_pagina ?></h1>
          <p class="lead"><?= $director ?: "Introdueix les dades de la nova pel·lícula" ?></p>
        </div>
      </div>
    </section>
  </div>

  <div class="album py-5 bg-light">
    <div class="container">

      <?php if ($is_insertat): ?>
        <div class="alert alert-success">Pel·lícula creada correctament!</div>
      <?php elseif ($is_actualitzat): ?>
        <div class="alert alert-success">Pel·lícula actualitzada correctament!</div>
      <?php endif; ?>

      <div class="row g-5">
        <!-- COLUMNA DERECHA -->
        <div class="col-md-5 col-lg-4 order-md-last">
          <h4 class="mb-3 text-dark">Portada</h4>
          <div class="text-center">
            <img src="<?= $imatge_portada ?>" class="object-fit-cover" alt="portada" height="395" width="100%">
          </div>

          <?php if (!empty($id)): ?>
            <hr class="my-4">
            <a href="#" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
              <i class="bi bi-trash"></i> Eliminar pel·lícula
            </a>

            <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Eliminar pel·lícula</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    Segur que vols eliminar <strong><?= $titol ?></strong>?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='delete.php?id=<?= $id ?>'">Sí, eliminar</button>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>

        <!-- COLUMNA IZQUIERDA -->
        <div class="col-md-7 col-lg-8">
          <h4 class="mb-3">Dades de la pel·lícula</h4>
          <form method="post" enctype="multipart/form-data" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="row g-3">
              <div class="col-sm-6">
                <label class="form-label">Títol</label>
                <input type="text" class="form-control" name="titol" value="<?= $titol ?>" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Valoració (1-5)</label>
                <select class="form-select" name="valoracio" required>
                  <?php for ($i = 5; $i >= 1; $i--): ?>
                    <option value="<?= $i ?>" <?= ($valoracio == $i) ? "selected" : "" ?>><?= $i ?></option>
                  <?php endfor; ?>
                </select>
              </div>

              <div class="col-6">
                <label class="form-label">País</label>
                <input class="form-control" list="paisos" name="pais" value="<?= $pais ?>" required>
                <datalist id="paisos">
                  <?php foreach ($llista_paisos_select as $pais_select): ?>
                    <option value="<?= $pais_select ?>">
                  <?php endforeach; ?>
                </datalist>
              </div>

              <div class="col-6">
                <label class="form-label">Director</label>
                <input type="text" class="form-control" name="director" value="<?= $director ?>" required>
              </div>

              <div class="col-6">
                <label class="form-label">Gènere</label>
                <select class="form-select" name="genere[]" multiple required>
                  <?php foreach ($llista_generes_select as $genere_select): ?>
                    <option value="<?= $genere_select ?>" <?= in_array($genere_select, $llista_generes_peli) ? "selected" : "" ?>><?= $genere_select ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-3">
                <label class="form-label">Duració (min)</label>
                <input type="number" class="form-control" name="duracio" value="<?= $duracio ?>" required>
              </div>

              <div class="col-3">
                <label class="form-label">Any</label>
                <input type="number" class="form-control" name="any" value="<?= $anyo ?>" required>
              </div>

              <div class="col-12">
                <label class="form-label">Sinopsi</label>
                <textarea class="form-control" name="sinopsi" rows="3" required><?= $sinopsi ?></textarea>
              </div>

              <div class="col-12">
                <label class="form-label">Imatge portada</label>
                <input type="file" class="form-control" name="imatge_portada" accept="image/*">
              </div>
            </div>

            <hr class="my-4">
            <button class="btn btn-primary w-100" type="submit" name="formulari" value="formulari">
              <i class="bi bi-floppy"></i> Guardar pel·lícula
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include_once __DIR__ . '/footer.php'; ?>
