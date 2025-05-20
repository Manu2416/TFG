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
</div>
    <?php
    require_once "../model/conexion.php";
    require_once "../model/clases.php";

    $bd = new BD();
    $conexion = $bd->iniciar_Conexion();
    $productos = Producto::obtenerPacks($conexion);
    ?>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 card-container">
    <?php foreach ($productos as $producto): ?>
      <div class="col">
          <div class="card h-100">
              <img src="<?= htmlspecialchars($producto['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['nombre']) ?>">
              <div class="card-body">
                  <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
                  <p class="card-text"><?= htmlspecialchars($producto['descripcion']) ?></p>
                  <p class="card-price"><?= number_format($producto['precio'], 2) ?> €</p>
              </div>
              <div class="card-footer text-center">
                  <a href="#" class="btn btn-primary">Añadir al carrito</a>
              </div>
          </div>
      </div>
    <?php endforeach; ?>
    </div>

</main>

<?php include '../includes/footer.php';?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
