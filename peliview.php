<?php
/**
 * Pàgina per visualitzar una pel·lícula concreta.
 */
require_once __DIR__.'/models/Peli.php';
require_once __DIR__.'/models/PeliDAO.php';
require_once __DIR__.'/models/Usuari.php';
require_once __DIR__.'/models/UsuariDAO.php';
require_once __DIR__.'/models/Valoracio.php';
require_once __DIR__.'/models/ValoracioDAO.php';
require_once __DIR__.'/models/utils.php';

session_start();

// Control de sessió d'usuari actiu.

if(!empty($_SESSION["usuari"]) || !empty($_COOKIE['usuari_recordat'])){

    //Usuario logueado

    $usuariActiu = true;

    //Le doy nombre el email almacenado en la session o en la cookie a la variable para que lo tenga en cuenta en caso de que haya usuarioActivo

    $nom = $_SESSION["usuari"] ?? $_COOKIE['usuari_recordat'];

} else {

    //Usuario no logueado

    $usuariActiu = false;
    
    //Le doy nombre guest=invitado a la variable para que lo tenga en cuenta en caso de q no haya usuarioActivo

    $nom = "Guest";

}

// Carrega la pel·lícula pel seu id (GET).

$peli = null;
$valoracio = null;

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET["id"]) && !empty($_GET["id"])) {

    //Limpiar datos y obtener el objeto pelicula con id

    $id = neteja_dades($_GET["id"]);
    $peli = PeliDAO::select($id);
    
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
            $valoracio -> setPeliId($id);
            $valoracio -> setUsuariId($usuari_id);
            $valoracio ->setValoracio($_GET['valoracio']);
            ValoracioDAO::insertarValoracio($valoracio);
            
            //Al recibir la informacion obtiene la valoracion
            //Esta variable acoje tu valoracion en esa pelicula
            
            $valPropia = $valoracio->getValoracio();
        
            //Esta variable deshabilitara el boton de enviar valoracion

            $valDisabled ="disabled";

        }else{
        
            //¡¡si no!!, es usuario pero no ha enviado valoracion
        
            $usuari_email = $_SESSION['usuari'] ?? $_COOKIE['usuari_recordat'];
            $usuari = UsuariDAO::selectByMail($usuari_email);
            $usuari_id = $usuari->getId();
            $valoracio = ValoracioDAO::selectByUserPeliId($usuari_id, $id);        
            if(empty($valoracio)){
                
                //Esta variable controla que no has valorado aun evitando un error por null pointer

                $valPropia = "No has valorado aun";
                
                //Esta variable habilitara el boton de enviar valoracion
                
                $valDisabled ="enabled";
                
                //si no
            }else{
                
                //Esta variable acoje tu valoracion en esa pelicula

                $valPropia = $valoracio->getValoracio();
                
                //Esta variable deshabilitara el boton de enviar valoracion
                
                $valDisabled ="disabled";
            }
    
        }
    }
    $valoracioMedia = ValoracioDAO::selectMediaByPeliId($id);
    
    if(!empty($valoracioMedia)){
        $valoracioMedia = round($valoracioMedia, 2);
    }
}

// Si no existeix la pel·lícula, mostra missatge i redirigeix a home.
if(empty($peli)){
    $_SESSION["misssatge_error"] = "No s'ha trobat la pel·lícula.";
    header('Location: index.php');
    exit;
}

include_once __DIR__ . '/header.php';
?>
<main>
    <?php if(!empty($peli)): ?>
        <div class="bg"
             style="background-image: url('uploads/<?= htmlspecialchars($peli->getImatge()) ?>');
                    background-size: cover;
                    background-position: center;
                    height: 30vh;">
            <section class="py-5 text-center container">
                <div class="row py-lg-5">
                    <div class="col-lg-6 col-md-8 mx-auto text-white">
                        <h1 class="fw-light"><?= htmlspecialchars($peli->getTitol()) ?></h1>
                        <p class="lead"><?= htmlspecialchars($peli->getDirector()) ?> - <?= $peli->getAny() ?></p>
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
                                <img src="uploads/<?= htmlspecialchars($peli->getImatge()) ?>" class="object-fit-cover" alt="portada_peli" height="450" width="100%">
                            </div>
                            <div class="col p-4 d-flex flex-column position-static">
                                <strong class="d-inline-block mb-2 text-primary">
                                    <?= htmlspecialchars($peli->getDirector()) ?> - <?= $peli->getAny() ?> - <?= htmlspecialchars($peli->getPais()) ?> - <?= htmlspecialchars($peli->getDuracio()) ?>
                                </strong>
                                <h1 class="d-inline-flex justify-content-between align-items-center">
                                    <?= htmlspecialchars($peli->getTitol()) ?>
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
                                <p class="card-text mb-auto"><?= htmlspecialchars($peli->getSinopsi()) ?></p>
                                <p class="mb-2 text-end">
                                    <?php
                                    $llista_generes = explode(",", $peli->getGenere());
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
                    <p>Tu valoracion a esta pelicula es <?= $valPropia ?? "" ?></p>
                </div>
                <?php
                endif;
                ?>
            </div>
        </div>
    <?php endif; ?>
</main>
<?php include_once __DIR__ . '/footer.php'; ?>