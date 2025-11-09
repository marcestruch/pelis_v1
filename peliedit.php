<?php
include_once __DIR__.'/models/PeliDAO.php';
include_once __DIR__.'/models/Peli.php';

include_once __DIR__.'/models/utils.php';

//Inicializar variables

$id ="";
$imatge_cap = "assets/film.jpg";
$titol_pagina="";
$titol="";
$director="";
$imatge_portada= "assets/proximamente.png";
$valoracio=1;
$generes="";
$llista_generes_peli=[];
$pais="";
$duracio =100;
$anyo = date("Y");
$sinopsi= "";

$is_actualitzat = false;
$is_insertat = false;

//inicializar selects

$llista_paisos_select = [
  'Espanya',
  'Estats Units',
  'Itália',
  'Japó',
  'Regne Unit'
];

$errores = [];
$missatge_ok = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){

  //titol
  $titol = neteja_dades($_POST["titol"] ?? "");
  if(empty($titol)){
    $errores["titol"] = "Título es un campo obligatorio";
  }

  //valoracio
  $valoracio = neteja_dades($_POST["valoracio"] ?? "");
  if(empty($valoracio)){
    $errores["valoracio"] = "Valoración es un campo obligatorio";
  }

  //director
  $director = neteja_dades($_POST["director"] ?? "");
  if(empty($director)){
    $errores["director"] = "Director es un campo obligatorio";
  }

  //pais
  $pais = neteja_dades($_POST["pais"] ?? "");
  if(empty($pais)){
    $errores["pais"] = "País es un campo obligatorio";
  }

  //genere
  $genere = implode(",", $_POST["genere"]);
  $genere = neteja_dades($genere ?? "");
  
  if(empty($genere)){
    $errores["genere"] = "Género es un campo obligatorio";
  }

  //duracio
  $duracio = neteja_dades($_POST["duracio"] ?? "");
  if(empty($duracio)){
    $errores["duracio"] = "Duración es un campo obligatorio";
  }

  //any
  $anyo = neteja_dades($_POST["any"] ?? "");
  if(empty($anyo)){
    $errores["any"] = "Año es un campo obligatorio";
  }

  //sinopsi
  $sinopsi = neteja_dades($_POST["sinopsi"] ?? "");
  if(empty($sinopsi)){
    $errores["sinopsi"] = "Sinopsi es un campo obligatorio";
  }

  //imatge
  if(!empty($_FILES["file_portada"]) && $_FILES["file_portada"]["error"]== 0){
    $imatge = pujar_imatge("file_portada", $titol);
  }

  //id
  $id = neteja_dades($_POST["id"] ?? "");


  //No hay errores
  if(empty($errores)){
    
    if(empty($id)){
      $peli = new Peli();
    } else {
      $peli = PeliDAO::select($id);
    }

    $peli->setTitol($titol);
    $peli->setValoracio($valoracio);
    $peli->setPais($pais);
    $peli->setDirector($director);
    $peli->setGenere($genere);
    $peli->setDuracio($duracio);
    $peli->setAny($anyo);
    $peli->setSinopsi($sinopsi);
    
    if(!empty($imatge)){
      $peli->setImatge($imatge);
    }

    //Insertamos la peli
    if(empty($id)){
      $id = PeliDAO::insert($peli);
      $peli->setId($id);
      $missatge_ok = "Película insertada correctamente";
    } else {
      PeliDAO::update($peli);
      $missatge_ok = "Película actualizada correctamente";
    }
    
  }

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
          <!--<p>
          <a href="#" class="btn btn-primary my-2">Main call to action</a>
          <a href="#" class="btn btn-secondary my-2">Secondary action</a>
        </p>-->
        </div>
      </div>

    </section>
  </div>
  <div class="album py-5 bg-light">
    <div class="container">

      <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-dark">Portada</span>
          </h4>
          <!-- imatge portada -->
          <div class="text-center">
            <img src="assets/proximamente.png" class="object-fit-cover" alt="portada_peli" height="395" width="100%">
          </div>
          <!-- Eliminar pel·lícula-->
          <hr class="my-4">
          <a href="#" class="w-100 btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="bi bi-trash"></i> Eliminar pel·lícula</a>


          <!-- Delete Modal -->
          <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="deleteModalLabel">Eliminar pel·lícula</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Segur que vols eliminar la pel·lícula <strong>Joker</strong>?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                  <button type="button" class="btn btn-danger" onclick="window.location.href='delete_peli.php?id=100';">Sí, eliminar pel·lícula</button>
                </div>
              </div>
            </div>
          </div>


        </div>
        <div class="col-md-7 col-lg-8">
          <h4 class="mb-3">Dades de la pel·lícula</h4>
          <form class="needs-validation" novalidate>
            <div class="row g-3">
              <div class="col-sm-6">
                <label for="firstName" class="form-label">Títol</label>
                <input type="text" class="form-control" name="titol" id="titol" placeholder="" value="" required>
                <div class="invalid-feedback">
                  El títol és obligatori
                </div>
              </div>

              <div class="col-md-6">
                <label for="valoracio" class="form-label">Valoració (sobre 5)</label>
                <select class="form-select" id="valoracio" required>
                  <option value="">Valoració...</option>
                  <option>5 - Excel·lent</option>
                  <option>4 - Bona</option>
                  <option>3 - Regular</option>
                  <option>2 - Fluixa</option>
                  <option>1 - Molt dolenta</option>
                </select>
                <div class="invalid-feedback">
                  Selecciona una valoració.
                </div>
              </div>

              <div class="col-6">
                <label for="exampleDataList" class="form-label">País</label>
                <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Escriu per buscar el nom del país..." required>
                <datalist id="datalistOptions">
                  <option value="España">
                  <option value="Estats Units">
                  <option value="Japó">
                  <option value="Regne Unit">
                </datalist>
                <div class="invalid-feedback">
                  El país és invàlid
                </div>
              </div>

              <div class="col-6">
                <label for="director" class="form-label">Director</label>
                <input type="text" class="form-control" id="director" placeholder="Director">
                <div class="invalid-feedback">
                  El director és invàlid
                </div>
              </div>

              <div class="col-6">
                <label for="genere" class="form-label">Gènere</label>
                <select class="form-select" name="genere" id="genere" multiple aria-label="multiple select example">
                  <option selected>Selecciona un o més géneres</option>
                  <option value="acció">Acció</option>
                  <option value="terror">Terror</option>
                  <option value="comedia">Comedia</option>
                  <option value="drama">Drama</option>
                  <option value="fantasia">Fantasia</option>
                </select>
                <div class="invalid-feedback">
                  Selecciona un génere
                </div>
              </div>

              <div class="col-3">
                <label for="duracio" class="form-label">Duració (minuts)</label>
                <input type="number" class="form-control" id="duracio" placeholder="100">
                <div class="invalid-feedback">
                  Duració invàlida
                </div>
              </div>
              <div class="col-3">
                <label for="any" class="form-label">Any</label>
                <input type="number" class="form-control" id="any" placeholder="2024">
                <div class="invalid-feedback">
                  Any invàlid
                </div>
              </div>

              <div class="col-12">
                <label for="exampleFormControlTextarea1" class="form-label">Sinopsi</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>

              <div class="col-12">
                <label for="file_portada" class="form-label">Imatge portada</label>
                <input type="file" class="form-control" name="file_portada" placeholder="imatge_portada">
              </div>


            </div>
            <!--
            <hr class="my-4">
  
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="same-address">
              <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
            </div>
  
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="save-info">
              <label class="form-check-label" for="save-info">Save this information for next time</label>
            </div>
  
            <hr class="my-4">
  
            <h4 class="mb-3">Payment</h4>
  
            <div class="my-3">
              <div class="form-check">
                <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
                <label class="form-check-label" for="credit">Credit card</label>
              </div>
              <div class="form-check">
                <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
                <label class="form-check-label" for="debit">Debit card</label>
              </div>
              <div class="form-check">
                <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
                <label class="form-check-label" for="paypal">PayPal</label>
              </div>
            </div>
  
            <div class="row gy-3">
              <div class="col-md-6">
                <label for="cc-name" class="form-label">Name on card</label>
                <input type="text" class="form-control" id="cc-name" placeholder="" required>
                <small class="text-muted">Full name as displayed on card</small>
                <div class="invalid-feedback">
                  Name on card is required
                </div>
              </div>
  
              <div class="col-md-6">
                <label for="cc-number" class="form-label">Credit card number</label>
                <input type="text" class="form-control" id="cc-number" placeholder="" required>
                <div class="invalid-feedback">
                  Credit card number is required
                </div>
              </div>
  
              <div class="col-md-3">
                <label for="cc-expiration" class="form-label">Expiration</label>
                <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                <div class="invalid-feedback">
                  Expiration date required
                </div>
              </div>
  
              <div class="col-md-3">
                <label for="cc-cvv" class="form-label">CVV</label>
                <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                <div class="invalid-feedback">
                  Security code required
                </div>
              </div>
            </div>
            -->
            <hr class="my-4">

            <button class="w-100 btn btn-primary btn-lg" type="submit"><i class="bi bi-floppy"></i> Guardar pel·lícula</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</main>

<?php
include_once __DIR__ . '/footer.php';
