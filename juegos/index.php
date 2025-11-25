<?php
// Inclou les classes de models per gestionar els jocs i usuaris.
require_once __DIR__.'/../models/Joc.php';
require_once __DIR__.'/../models/JocDAO.php';
require_once __DIR__.'/../models/Usuari.php';
require_once __DIR__.'/../models/UsuariDAO.php';

// Inicia sessió per treballar amb l'usuari connectat i mostrar missatges.
session_start();

// Variable on es guarda la llista de jocs a mostrar.
$llistaJocs = [];

// Mostra missatge d'error si existeix a la sessió.
$missatge_error = "";
if(!empty($_SESSION["misssatge_error"])){
    $missatge_error = $_SESSION["misssatge_error"];
    $_SESSION["misssatge_error"] = "";
}

// Cerca jocs per títol/desenvolupador.
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['joc_query'])) {
    $joc_query = trim($_POST['joc_query']);
    $llistaJocs = JocDAO::getSearch($joc_query);
} else {
    $llistaJocs = JocDAO::getAll();
}

// Control de sessió per saber si hi ha usuari actiu.
if(!empty($_SESSION["usuari"]) || !empty($_COOKIE['usuari_recordat'])){
    $usuariActiu = true;
    $nom = $_SESSION["usuari"] ?? $_COOKIE['usuari_recordat'];
} else {
    $usuariActiu = false;
    $nom = "Guest";
}

// Defineix el prefix per als enllaços del header
$path_prefix = "../";
// Carrega la capçalera HTML.
include_once __DIR__ . '/../header.php';
?>
<main>
    <div class="bg"
         style="background-image: url('../assets/games.jpg');
                background-size: cover;
                background-position: center;
                height: 30vh;">
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto text-white">
                    <h1 class="fw-light">Jocs DWES</h1>
                    <p class="lead">Col·lecció de videojocs.</p>
                    <form method="post" action="#">
                        <div class="input-group">
                            <input class="form-control" type="text" name="joc_query" placeholder="Quin joc estàs buscant?" aria-label="Buscar">
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

            <?php if(empty($llistaJocs)): ?>
                <h2>No hi ha jocs</h2>
            <?php endif; ?>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach($llistaJocs as $joc): ?>
                <!-- INICI JOC -->
                <div class="col">
                    <div class="card shadow-sm">
                        <img class="card-img-top object-fit-cover" height="450" width="100%" src="../uploads/<?= htmlspecialchars($joc->getImatge()) ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($joc->getTitol()) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($joc->getDescripcio()) ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><?= $joc->getAny() ?></small>
                                <div class="btn-group">
                                    <a href="view.php?id=<?= $joc->getId() ?>" class="btn btn-dark"><i class="fa fa-eye"></i></a>
                                    <?php if($usuariActiu): ?>
                                        <a href="edit.php?id=<?= $joc->getId() ?>" class="btn btn-danger"><i class="fa fa-pencil-square"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FI JOC -->
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>

<?php include_once __DIR__ . '/../footer.php'; ?>
