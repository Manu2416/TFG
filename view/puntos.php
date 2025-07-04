<?php
session_start();

// Si no hay usuario en sesión, redirigir a login
if (!isset($_SESSION['usuario'])) {
    $_SESSION["error"] = "Debes iniciar sesion para acceder a esta página";
    header('Location: ../view/iniciarsesion.php');
    
    exit();
}

// Guardamos los puntos en variable para usar en HTML
$puntos = $_SESSION['usuario']['puntos'] ?? 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Premios</title>
     <!-- Estilos propios -->
    <link href="../styles/footer.css" rel="stylesheet" />
    <link href="../styles/navbar.css" rel="stylesheet" />
    <link href="../styles/body.css" rel="stylesheet" />
    <link href="../styles/productos.css" rel="stylesheet" />
      <!-- Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>
<?php if (isset($_SESSION['error-carrito'])): ?>
  <script>
    const mensajeErrorCarrito = <?= json_encode($_SESSION['error-carrito']) ?>;
  </script>
  <?php unset($_SESSION['error-carrito']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success-carrito'])): ?>
  <script>
    const mensajeExitoCarrito = <?= json_encode($_SESSION['success-carrito']) ?>;
  </script>
  <?php unset($_SESSION['success-carrito']); ?>
<?php endif; ?>
<body>
<?php include '../includes/cabecera.php'; ?>

<div class="container-fluid mt-3">
    <div class="row d-flex justify-content-end">
        <div class="col-auto puntos mx-5">
            <img src="../images/moneda.png" alt="Moneda" />
            <p><?= $puntos ?></p>
        </div>
    </div>
</div>

<!-- Modal Error -->
<div class="modal fade" id="modalErrorCarrito" tabindex="-1" aria-labelledby="modalErrorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-danger">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="modalErrorLabel">Error</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="modalErrorTexto"></div>
    </div>
  </div>
</div>

<!-- Modal Éxito -->
<div class="modal fade" id="modalExitoCarrito" tabindex="-1" aria-labelledby="modalExitoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="modalExitoLabel">Éxito</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="modalExitoTexto"></div>
    </div>
  </div>
</div>

<?php
require_once "../model/conexion.php";
require_once "../model/clases.php";

$bd = new BD();
$conexion = $bd->iniciar_Conexion();
$productos = Producto::obtenerPremios($conexion);
?>



<main class="container mb-5">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 card-container">
       <?php foreach ($productos as $producto): ?>
            <div class="col">
                <div class="card h-100">
                    <img src="<?= htmlspecialchars($producto['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($producto['descripcion']) ?></p>
                        <p class="card-price card-price-puntos">
                            <?= $producto['precio_puntos'] ?>
                            <img src="../images/moneda.png" alt="Moneda" style="width: 40px; height: 40px;">
                        </p>
                    </div>
                    <div class="card-footer text-center">
                        <form method="POST" action="../controller/aniadir_carrito_puntos.php">
                            <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                            <button type="submit" class="btn btn-primary">canjear</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>



<?php include '../includes/footer.php'; ?>
<script src="../scripts/modadlerror.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
