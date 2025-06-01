<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Ecoffe</title>
     <!-- Estilos propios -->
    <link href="../styles/footer.css" rel="stylesheet">
    <link href="../styles/navbar.css" rel="stylesheet">
    <link href="../styles/body.css" rel="stylesheet">
    <link href="../styles/reseña.css" rel="stylesheet">
  
    <!-- Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   

</head>
<body>
    
<?php include '../includes/cabecera.php'; ?>
<div class="banner" id="banner">
  <div class="banner-track" id="bannerTrack">
    <p class="banner-text">¡Bienvenidos a nuestra web! Disfruta de los mejores cafés ecológicos y compostables</p>
    <p class="banner-text">¡Bienvenidos a nuestra web! Disfruta de los mejores cafés ecológicos y compostables</p>
    <p class="banner-text">¡Bienvenidos a nuestra web! Disfruta de los mejores cafés ecológicos y compostables</p>
    <p class="banner-text">¡Bienvenidos a nuestra web! Disfruta de los mejores cafés ecológicos y compostables</p>
    <p class="banner-text">¡Bienvenidos a nuestra web! Disfruta de los mejores cafés ecológicos y compostables</p>
    <p class="banner-text">¡Bienvenidos a nuestra web! Disfruta de los mejores cafés ecológicos y compostables</p>
    <p class="banner-text">¡Bienvenidos a nuestra web! Disfruta de los mejores cafés ecológicos y compostables</p>
    <p class="banner-text">¡Bienvenidos a nuestra web! Disfruta de los mejores cafés ecológicos y compostables</p>
    <p class="banner-text">¡Bienvenidos a nuestra web! Disfruta de los mejores cafés ecológicos y compostables</p>
  </div>
</div>
<main>
<?php include '../includes/box.php';?>

<section class="reseñas-section container-fluid my-5">
  <h2 class="reseñas-section__titulo text-center">Reseñas de nuestros clientes</h2>
  <div class="row row-cols-1 row-cols-md-3 g-4">

    <div class="col">
      <div class="card reseñas-section__card text-center shadow rounded-4">
        <div class="card-body">
          <div class="reseñas-section__header">
            <img src="../images/perfil2.jpg" alt="Foto mario" class="reseñas-section__header-imagen" />
            <div>
              <h5 class="reseñas-section__header-nombre">Mario Sobrinos</h5>
              <small class="reseñas-section__header-cargo">Experto del cafe</small>
            </div>
          </div>
          <p class="reseñas-section__texto">Excelente calidad y servicio. ¡Volveré a comprar sin duda!</p>
          <i class="bi bi-star-fill reseñas-section__icono"></i>
          <i class="bi bi-star-fill reseñas-section__icono"></i>
          <i class="bi bi-star-fill reseñas-section__icono"></i>
          <i class="bi bi-star-fill reseñas-section__icono"></i>
          <i class="bi bi-star-half reseñas-section__icono"></i>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card reseñas-section__card text-center shadow rounded-4">
        <div class="card-body">
          <div class="reseñas-section__header">
            <img src="../images/perfil3.jpg" alt="Foto Paula" class="reseñas-section__header-imagen" />
            <div>
              <h5 class="reseñas-section__header-nombre">Paula Muñoz</h5>
              <small class="reseñas-section__header-cargo">Amante del arte</small>
            </div>
          </div>
          <p class="reseñas-section__texto">Muy buen producto, el envío fue rápido y la atención excelente.</p>
          <i class="bi bi-star-fill reseñas-section__icono"></i>
          <i class="bi bi-star-fill reseñas-section__icono"></i>
          <i class="bi bi-star-fill reseñas-section__icono"></i>
          <i class="bi bi-star-fill reseñas-section__icono"></i>
          <i class="bi bi-star-fill reseñas-section__icono"></i>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card reseñas-section__card text-center shadow rounded-4">
        <div class="card-body">
          <div class="reseñas-section__header">
            <img src="../images/perfil1.jpg" alt="Foto Maria" class="reseñas-section__header-imagen" />
            <div>
              <h5 class="reseñas-section__header-nombre">Maria Dragneva</h5>
              <small class="reseñas-section__header-cargo">Intento de backend</small>
            </div>
          </div>
          <p class="reseñas-section__texto">¡Gracias a este cafe cogi fuerzas para hacer mi tfg!</p>
          <i class="bi bi-star-fill reseñas-section__icono"></i>
          <i class="bi bi-star-fill reseñas-section__icono"></i>
          <i class="bi bi-star-fill reseñas-section__icono"></i>
          <i class="bi bi-star-fill reseñas-section__icono"></i>
          <i class="bi bi-star-half reseñas-section__icono"></i>
        </div>
      </div>
    </div>

  </div>
</section>

</main>

<?php include '../includes/footer.php';?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>
</html>