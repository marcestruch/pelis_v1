<?php
/**
 * Pàgina per visualitzar un joc concret.
 */
require_once __DIR__.'/../models/Joc.php';
require_once __DIR__.'/../models/JocDAO.php';
require_once __DIR__.'/../models/Usuari.php';
require_once __DIR__.'/../models/UsuariDAO.php';
require_once __DIR__.'/../models/Valoracio.php';
require_once __DIR__.'/../models/ValoracioDAO.php';
require_once __DIR__.'/../models/utils.php';

session_start();

// Control de sessió d'usuari actiu.
if(!empty($_SESSION["usuari"]) || !empty($_COOKIE['usuari_recordat'])){
    $usuariActiu = true;
    $nom = $_SESSION["usuari"] ?? $_COOKIE['usuari_recordat'];
} else {
    $usuariActiu = false;
    $nom = "Guest";
}

// Carrega el joc pel seu id (GET).
$joc = null;
$valoracio = null;

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET["id"]) && !empty($_GET["id"])) {

    //Limpiar datos y obtener el objeto joc con id
    $id = neteja_dades($_GET["id"]);
    $joc = JocDAO::select($id);
    
    if($usuariActiu){
        //Si viene de enviar el formulario con la valoracion y es usuario
        if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET["id"]) && !empty($_GET["id"]) && isset($_GET["valoracio"])){
        
            //Obtengo la id del usuari
            $usuari_email = $_SESSION['usuari'] ?? $_COOKIE['usuari_recordat'];
            $usuari = UsuariDAO::selectByMail($usuari_email);
            $usuari_id = $usuari->getId();
        
            //Creo una nueva valoracion para insetar el objeto seteado con los atributos correspondientes
            $valoracio = new Valoracio();
            $valoracio -> setId(null);
            $valoracio -> setJocId($id);
            $valoracio -> setUsuariId($usuari_id);
            $valoracio ->setValoracio($_GET['valoracio']);
            ValoracioDAO::insertarValoracio($valoracio);
            
            $valPropia = $valoracio->getValoracio();
            $valDisabled ="disabled";

        }else{
            //¡¡si no!!, es usuario pero no ha enviado valoracion
            $usuari_email = $_SESSION['usuari'] ?? $_COOKIE['usuari_recordat'];
            $usuari = UsuariDAO::selectByMail($usuari_email);
            $usuari_id = $usuari->getId();
            $valoracio = ValoracioDAO::selectByUserJocId($usuari_id, $id);        
            if(empty($valoracio)){
                $valPropia = "No has valorado aun";
                $valDisabled ="enabled";
            }else{
                $valPropia = $valoracio->getValoracio();
                $valDisabled ="disabled";
            }
        }
    }
    
    //Dar valoracion Media a todos 
    $valoracioMedia = ValoracioDAO::selectMediaByJocId($id);
    
    //Si valoracionMedia no esta vacia Redondea el resultado a dos decimales con Round
    if(!empty($valoracioMedia)){
        $valoracioMedia = round($valoracioMedia, 2);
    }
}

// Si no existeix el joc, mostra missatge i redirigeix a home.
if(empty($joc)){
    $_SESSION["misssatge_error"] = "No s'ha trobat el joc.";
    header('Location: index.php');
    exit;
}

$path_prefix = "../";
include_once __DIR__ . '/../header.php';
?>
<main>
    <?php if(!empty($joc)): ?>
        <div class="bg"
             style="background-image: url('../uploads/<?= htmlspecialchars($joc->getImatge()) ?>');
                    background-size: cover;
                    background-position: center;
                    height: 30vh;">
            <section class="py-5 text-center container">
                <div class="row py-lg-5">
                    <div class="col-lg-6 col-md-8 mx-auto text-white">
                        <h1 class="fw-light"><?= htmlspecialchars($joc->getTitol()) ?></h1>
                        <p class="lead"><?= htmlspecialchars($joc->getDesenvolupador()) ?> - <?= $joc->getAny() ?></p>
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
                                <img src="../uploads/<?= htmlspecialchars($joc->getImatge()) ?>" class="object-fit-cover" alt="portada_joc" height="450" width="100%">
                            </div>
                            <div class="col p-4 d-flex flex-column position-static">
                                <strong class="d-inline-block mb-2 text-primary">
                                    <?= htmlspecialchars($joc->getDesenvolupador()) ?> - <?= $joc->getAny() ?> - <?= htmlspecialchars($joc->getPais()) ?>
                                </strong>
                                <h1 class="d-inline-flex justify-content-between align-items-center">
                                    <?= htmlspecialchars($joc->getTitol()) ?>
                                    <span class="ms-3">
                                        <?php
                                        $i = 1;
                                        $valEstrella = $valoracioMedia;
                                        while($i <= $valEstrella){
                                            echo '<i class="bi bi-star-fill fs-5"></i>';
                                            $i++;
                                        }
                                        while($i <= 5){
                                            echo '<i class="bi bi-star fs-5"></i>';
                                            $i++;
                                        }
                                        ?>
                                    </span>
                                </h1>
                                <p class="card-text mb-auto"><?= htmlspecialchars($joc->getDescripcio()) ?></p>
                                <p class="mb-2 text-end">
                                    <?php
                                    $llista_generes = explode(",", $joc->getGenere());
                                    foreach($llista_generes as $genere){
                                        $genere = trim($genere);
                                        echo '<a href="index.php?genere=' . urlencode($genere) . '" class="btn btn-primary">' . htmlspecialchars($genere) . '</a> ';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div> 
                <div>
                    <p>La valoracion media es: <?= $valoracioMedia ?? 0?></p>
                </div>
                <?php
                if($usuariActiu):
                ?>
                <div class="form">
                    <form method="get">
                        <input type="hidden" name="id" value="<?= $_GET['id'] ?? '' ?>">
                        <input type="radio" name="valoracio" id="1" value="<?= 1?>">
                        <input type="radio" name="valoracio" id="2" value="<?= 2?>">
                        <input type="radio" name="valoracio" id="3" value="<?= 3?>">
                        <input type="radio" name="valoracio" id="4" value="<?= 4?>">
                        <input type="radio" name="valoracio" id="5" value="<?= 5?>">
                        <button type="submit" <?= $valDisabled?>>Enviar valoracio</button>
                    </form>
                    <p>Tu valoracion a este juego es <?= $valPropia ?? "" ?></p>
                </div>
                <?php
                endif;
                ?>
            </div>
        </div>
    <?php endif; ?>
</main>
<?php include_once __DIR__ . '/../footer.php'; ?>
