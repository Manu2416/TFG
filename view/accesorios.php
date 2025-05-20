<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Estilos propios -->
    <link href="../styles/footer.css" rel="stylesheet">
    <link href="../styles/navbar.css" rel="stylesheet">
    <link href="../styles/body.css" rel="stylesheet">
    <link href="../styles/productos.css" rel="stylesheet">
   
    <!-- Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include '../includes/cabecera.php'; ?>

<main class="container mb-5">
    
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 card-container">
    
    <!-- Producto 1 -->
    <div class="col">
      <div class="card h-100">
        <img src="../images/accesorio.jpg" class="card-img-top" alt="Taza de Cerámica 'Despertar'">
        <div class="card-body">
          <h5 class="card-title">Taza de Cerámica "Despertar"</h5>
          <p class="card-text">Una taza elegante, ideal para tu café matutino. Capacidad de 300 ml.</p>
          <p class="card-price">7,50 €</p>
        </div>
        <div class="card-footer text-center">
          <a href="#" class="btn btn-primary">Añadir al carrito</a>
        </div>
      </div>
    </div>

    <!-- Producto 2 -->
    <div class="col">
      <div class="card h-100">
        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Termo 'Café On-the-Go'">
        <div class="card-body">
          <h5 class="card-title">Termo "Café On-the-Go"</h5>
          <p class="card-text">Mantén tu café caliente todo el día con este termo de acero inoxidable.</p>
          <p class="card-price">15,00 €</p>
        </div>
        <div class="card-footer text-center">
          <a href="#" class="btn btn-primary">Añadir al carrito</a>
        </div>
      </div>
    </div>

    <!-- Producto 3 -->
    <div class="col">
      <div class="card h-100">
        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Soporte para Taza 'Relax'">
        <div class="card-body">
          <h5 class="card-title">Soporte para Taza "Relax"</h5>
          <p class="card-text">Un elegante soporte de madera para acompañar tu taza favorita.</p>
          <p class="card-price">12,00 €</p>
        </div>
        <div class="card-footer text-center">
          <a href="#" class="btn btn-primary">Añadir al carrito</a>
        </div>
      </div>
    </div>

    <!-- Producto 4 -->
    <div class="col">
      <div class="card h-100">
        <img src="../images/accesorio.jpg" class="card-img-top" alt="Café Manual 'Brewmaster'">
        <div class="card-body">
          <h5 class="card-title">Café Manual "Brewmaster"</h5>
          <p class="card-text">Prepara café de alta calidad con esta prensa francesa compacta.</p>
          <p class="card-price">18,00 €</p>
        </div>
        <div class="card-footer text-center">
          <a href="#" class="btn btn-primary">Añadir al carrito</a>
        </div>
      </div>
    </div>

    <!-- Producto 5 -->
    <div class="col">
      <div class="card h-100">
        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Molinillo de Café 'Aroma Perfecto'">
        <div class="card-body">
          <h5 class="card-title">Molinillo de Café "Aroma Perfecto"</h5>
          <p class="card-text">Muele tu café a mano para una experiencia única y fresca.</p>
          <p class="card-price">20,00 €</p>
        </div>
        <div class="card-footer text-center">
          <a href="#" class="btn btn-primary">Añadir al carrito</a>
        </div>
      </div>
    </div>

    <!-- Producto 6 -->
    <div class="col">
      <div class="card h-100">
        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Camiseta 'Amante del Café'">
        <div class="card-body">
          <h5 class="card-title">Camiseta "Amante del Café"</h5>
          <p class="card-text">Una camiseta con diseño moderno, ideal para los fanáticos del café.</p>
          <p class="card-price">14,00 €</p>
        </div>
        <div class="card-footer text-center">
          <a href="#" class="btn btn-primary">Añadir al carrito</a>
        </div>
      </div>
    </div>

  </div>
</main>

<?php include '../includes/footer.php';?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
