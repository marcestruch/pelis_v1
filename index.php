<?php
session_start();

// Control de sessió per saber si hi ha usuari actiu.
if(!empty($_SESSION["usuari"]) || !empty($_COOKIE['usuari_recordat'])){
    $usuariActiu = true;
    $nom = $_SESSION["usuari"] ?? $_COOKIE['usuari_recordat'];
} else {
    $usuariActiu = false;
    $nom = "Guest";
}

$path_prefix = "./";
include_once __DIR__ . '/header.php';
?>

<main>
    <div class="bg-dark text-secondary px-4 py-5 text-center" style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
        <div class="py-5">
            <h1 class="display-5 fw-bold text-white">Benvingut a Pelis & Jocs DWES</h1>
            <div class="col-lg-6 mx-auto">
                <p class="fs-5 mb-4 text-light">Tria què vols veure avui. Una col·lecció de les millors pel·lícules o els videojocs més destacats.</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="peliculas/index.php" class="btn btn-outline-info btn-lg px-4 me-sm-3 fw-bold">
                        <i class="bi bi-film"></i> Pel·lícules
                    </a>
                    <a href="juegos/index.php" class="btn btn-outline-warning btn-lg px-4 fw-bold">
                        <i class="bi bi-controller"></i> Jocs
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include_once __DIR__ . '/footer.php'; ?>