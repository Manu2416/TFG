<?php
session_start();
require_once "../model/conexion.php";
require_once "../model/clases.php";

$pedidoId = isset($_GET['pedido_id']) ? (int)$_GET['pedido_id'] : null;

if (!$pedidoId) {
  header("Location: ../index.php");
  exit;
}

$bd = new BD();
$conexion = $bd->iniciar_Conexion();

$pedido = new Pedido($conexion);
$detalle = new DetallePedido($conexion);

$datosPedido = $pedido->obtenerPorId($pedidoId);
$detalles = $detalle->obtenerPorPedidoId($pedidoId);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gracias por tu compra</title>
  <link href="../styles/footer.css" rel="stylesheet" />
  <link href="../styles/navbar.css" rel="stylesheet" />
  <link href="../styles/body.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
</head>
<body>



<main class="container py-5">
  <h1 class="text-center mb-4">¡Gracias por tu compra!</h1>

  <?php if ($datosPedido): ?>
    <div class="alert alert-success text-center">
      Tu pedido <strong>#<?= $datosPedido['id'] ?></strong> ha sido procesado el <strong><?= $datosPedido['fecha'] ?></strong>.
    </div>

    <div class="mb-4">
      <h4>Resumen del pedido</h4>
      <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
          <thead class="table-light">
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio unitario</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $total = 0;
            foreach ($detalles as $item):
              $subtotal = $item['cantidad'] * $item['precio_unitario'];
              $total += $subtotal;
            ?>
              <tr>
                <td><?= htmlspecialchars($item['nombre']) ?></td>
                <td><?= $item['cantidad'] ?></td>
                <td><?= number_format($item['precio_unitario'], 2) ?> €</td>
                <td><?= number_format($subtotal, 2) ?> €</td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="text-end mb-4">
      <h5>Total pagado: <strong><?= number_format($datosPedido['total'], 2) ?> €</strong></h5>
      <h6>Puntos ganados: <span class="text-success fw-bold"><?= $datosPedido['puntos_ganados'] ?> puntos</span></h6>
    </div>

    <div class="text-center">
      <a href="../index.php" class="btn btn-primary">Volver al inicio</a>
    </div>

  <?php else: ?>
    <div class="alert alert-danger text-center">
      No se encontró información del pedido.
    </div>
  <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
