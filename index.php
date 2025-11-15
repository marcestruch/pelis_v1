<?php
// Inclou les classes de models per gestionar les pel·lícules i usuaris.
require_once __DIR__.'/models/Peli.php';
require_once __DIR__.'/models/PeliDAO.php';
require_once __DIR__.'/models/Usuari.php';
require_once __DIR__.'/models/UsuariDAO.php';

// Inicia sessió per treballar amb l'usuari connectat i mostrar missatges.
session_start();

// Variable on es guarda la llista de pel·lícules a mostrar.
$llistaPelis = [];

// Mostra missatge d'error si existeix a la sessió.
$missatge_error = "";
if(!empty($_SESSION["misssatge_error"])){
    $missatge_error = $_SESSION["misssatge_error"];
    $_SESSION["misssatge_error"] = "";
}

// Cerca pel·lícules per títol/director o pel gènere, si es fa cerca POST o per URL ?genere.
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['peli_query'])) {
    $peli_query = trim($_POST['peli_query']);
    $llistaPelis = PeliDAO::getSearch($peli_query);
} else if(isset($_GET["genere"]) && !empty($_GET["genere"])) {
    $genere = $_GET["genere"];
    $llistaPelis = PeliDAO::getByGenere($genere);
} else {
    $llistaPelis = PeliDAO::getAll();
}

// Control de sessió per saber si hi ha usuari actiu.
if(!empty($_SESSION["usuari"]) || !empty($_COOKIE['usuari_recordat'])){
    $usuariActiu = true;
    $nom = $_SESSION["usuari"] ?? $_COOKIE['usuari_recordat'];
} else {
    $usuariActiu = false;
    $nom = "Guest";
}

// Carrega la capçalera HTML.
include_once __DIR__ . '/header.php';
?>
<main>
    <div class="bg"
         style="background-image: url('assets/film.jpg');
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
            <?php if(!empty($missatge_error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($missatge_error) ?>
                </div>
            <?php endif; ?>

            <?php if(empty($llistaPelis)): ?>
                <h2>No hi ha pel·lícules</h2>
            <?php endif; ?>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach($llistaPelis as $peli): ?>
                <!-- INICI PEL·LÍCULA -->
                <div class="col">
                    <div class="card shadow-sm">
                        <img class="card-img-top object-fit-cover" height="450" width="100%" src="uploads/<?= htmlspecialchars($peli->getImatge()) ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($peli->getTitol()) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($peli->getSinopsi()) ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><?= $peli->getAny() ?></small>
                                <div class="btn-group">
                                    <a href="peliview.php?id=<?= $peli->getId() ?>" class="btn btn-dark"><i class="fa fa-eye"></i></a>
                                    <?php if($usuariActiu): ?>
                                        <a href="peliedit.php?id=<?= $peli->getId() ?>" class="btn btn-danger"><i class="fa fa-pencil-square"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FI PEL·LÍCULA -->
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>

<?php include_once __DIR__ . '/footer.php'; ?>