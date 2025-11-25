<?php
/**
 * Pàgina per crear i editar jocs.
 */
include_once __DIR__.'/../models/JocDAO.php';
include_once __DIR__.'/../models/Joc.php';
include_once __DIR__.'/../models/utils.php';
session_start();

// Inicialitza variables de joc.
$id = "";
$imatge_cap = "../assets/games.jpg";
$titol_pagina = "Nou joc";
$titol = "";
$desenvolupador = "";
$imatge_portada = "../assets/proximamente.png";
$valoracio = 1;
$generes = "";
$llista_generes_joc = [];
$pais = "";
$any = date("Y");
$descripcio = "";

$is_insertat = false;
$is_actualitzat = false;

// Llista de països i gèneres predefinits.
$llista_paisos_select = ['Espanya', 'Estats Units', 'Japó', 'Regne Unit', 'Canadà', 'França'];
$llista_generes_select = ['Acció', 'Aventura', 'RPG', 'Estratègia', 'Esports', 'Simulació', 'Terror', 'Plataformes'];

// Control de sessió d'usuari actiu.
if(!empty($_SESSION["usuari"]) || !empty($_COOKIE['usuari_recordat'])){
    $usuariActiu = true;
    $nom = $_SESSION["usuari"] ?? $_COOKIE['usuari_recordat'];
} else {
    $usuariActiu = false;
    $nom = "Guest";
}
// Bloqueja la pàgina a usuaris no connectats.
if(empty($_SESSION["usuari"])){
    $_SESSION["misssatge_error"] = "No pots accedir no eres usuari";
    header("Location: index.php");
    exit;
}

// Si ve per GET (carrega un joc existent pel seu id).
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET["id"]) && !empty($_GET["id"])) {
        $id = neteja_dades($_GET["id"]);
        $joc = JocDAO::select($id);
        if (!$joc) {
            $_SESSION["misssatge_error"] = "El joc amb ID $id no existeix.";
            header("Location: index.php");
            exit;
        }
        // Carrega les dades del joc.
        $imatge_cap = (!empty($joc->getImatge())) ? "../uploads/" . $joc->getImatge() : "../assets/games.jpg";
        $titol = $joc->getTitol();
        $titol_pagina = $titol;
        $imatge_portada = (!empty($joc->getImatge())) ? "../uploads/" . $joc->getImatge() : "../assets/proximamente.png";
        $valoracio = $joc->getValoracio();
        $desenvolupador = $joc->getDesenvolupador();
        $generes = $joc->getGenere();
        $llista_generes_joc = explode(",", $generes);
        $pais = $joc->getPais();
        $any = $joc->getAny();
        $descripcio = $joc->getDescripcio();
    }
}

// Si ve per POST (inserta o actualitza joc).
if (isset($_POST['formulari'])) {
    $id = neteja_dades($_POST["id"] ?? "");
    $titol = neteja_dades($_POST["titol"] ?? "");
    $valoracio = neteja_dades($_POST["valoracio"] ?? 1);
    $desenvolupador = neteja_dades($_POST["desenvolupador"] ?? "");
    $pais = neteja_dades($_POST["pais"] ?? "");
    $generes = neteja_dades(implode(",", $_POST["genere"] ?? []));
    $any = neteja_dades($_POST["any"] ?? date("Y"));
    $descripcio = neteja_dades($_POST["descripcio"] ?? "");

    // Gestió de la pujada d'imatge.
    $imatge_nova = "";
    if (isset($_FILES['imatge_portada']) && $_FILES['imatge_portada']['error'] == 0) {
        $imatge_nova = pujar_imatge("imatge_portada", $titol);
    }

    // Inserta nou joc si no hi ha id.
    if (empty($id)) {
        $joc = new Joc();
        $joc->setTitol($titol);
        $joc->setDesenvolupador($desenvolupador);
        $joc->setValoracio($valoracio);
        $joc->setGenere($generes);
        $joc->setPais($pais);
        $joc->setAny($any);
        $joc->setDescripcio($descripcio);
        if (!empty($imatge_nova)) {
            $joc->setImatge($imatge_nova);
        }
        $id = JocDAO::insert($joc);
        $joc->setId($id);
        $is_insertat = true;
    }
    // Si hi ha id, actualitza el joc existent.
    else {
        $joc = JocDAO::select($id);
        if (!$joc) {
            $_SESSION["misssatge_error"] = "No s'ha pogut actualitzar: el joc no existeix.";
            header("Location: index.php");
            exit;
        }
        $joc->setTitol($titol);
        $joc->setDesenvolupador($desenvolupador);
        $joc->setValoracio($valoracio);
        $joc->setGenere($generes);
        $joc->setPais($pais);
        $joc->setAny($any);
        $joc->setDescripcio($descripcio);
        if (!empty($imatge_nova)) {
            $joc->setImatge($imatge_nova);
        }
        JocDAO::update($joc);
        $is_actualitzat = true;
    }

    // Actualitza les imatges a la pàgina segons el joc últim.
    if (!empty($joc->getImatge())) {
        $imatge_cap = '../uploads/' . $joc->getImatge();
        $imatge_portada = '../uploads/' . $joc->getImatge();
    }

    $llista_generes_joc = explode(",", $joc->getGenere());
    $titol_pagina = $titol;
}

$path_prefix = "../";
include_once __DIR__ . '/../header.php';
?>

<main>
    <div class="bg"
         style="background-image:url('<?= htmlspecialchars($imatge_cap) ?>');
                background-size:cover;
                background-position:center;
                height:30vh;">
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto text-white">
                    <h1 class="fw-light"><?= htmlspecialchars($titol_pagina) ?></h1>
                    <p class="lead"><?= $desenvolupador ?: "Introdueix les dades del nou joc" ?></p>
                </div>
            </div>
        </section>
    </div>
    <div class="album py-5 bg-light">
        <div class="container">
            <?php if ($is_insertat): ?>
                <div class="alert alert-success">Joc creat correctament!</div>
            <?php elseif ($is_actualitzat): ?>
                <div class="alert alert-success">Joc actualitzat correctament!</div>
            <?php endif; ?>

            <div class="row g-5">
                <!-- COLUMNA DRETA --->
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="mb-3 text-dark">Portada</h4>
                    <div class="text-center">
                        <img src="<?= htmlspecialchars($imatge_portada) ?>" class="object-fit-cover" alt="portada" height="395" width="100%">
                    </div>

                    <?php if (!empty($id)): ?>
                        <hr class="my-4">
                        <a href="#" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i> Eliminar joc
                        </a>
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Eliminar joc</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Segur que vols eliminar <strong><?= htmlspecialchars($titol) ?></strong>?
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

                <!-- COLUMNA ESQUERRA --->
                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">Dades del joc</h4>
                    <form method="post" enctype="multipart/form-data" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label">Títol</label>
                                <input type="text" class="form-control" name="titol" value="<?= htmlspecialchars($titol) ?>" required>
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
                                <input class="form-control" list="paisos" name="pais" value="<?= htmlspecialchars($pais) ?>" required>
                                <datalist id="paisos">
                                    <?php foreach ($llista_paisos_select as $pais_select): ?>
                                        <option value="<?= $pais_select ?>">
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Desenvolupador</label>
                                <input type="text" class="form-control" name="desenvolupador" value="<?= htmlspecialchars($desenvolupador) ?>" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Gènere</label>
                                <select class="form-select" name="genere[]" multiple required>
                                    <?php foreach ($llista_generes_select as $genere_select): ?>
                                        <option value="<?= $genere_select ?>" <?= in_array($genere_select, $llista_generes_joc) ? "selected" : "" ?>><?= $genere_select ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Any</label>
                                <input type="number" class="form-control" name="any" value="<?= htmlspecialchars($any) ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descripció</label>
                                <textarea class="form-control" name="descripcio" rows="3" required><?= htmlspecialchars($descripcio) ?></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Imatge portada</label>
                                <input type="file" class="form-control" name="imatge_portada" accept="image/*">
                            </div>
                        </div>
                        <hr class="my-4">
                        <button class="btn btn-primary w-100" type="submit" name="formulari" value="formulari">
                            <i class="bi bi-floppy"></i> Guardar joc
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include_once __DIR__ . '/../footer.php'; ?>
