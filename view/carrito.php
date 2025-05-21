<?php
session_start();
$carrito = $_SESSION['carrito'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Carrito de Compras</title>
  <link href="../styles/footer.css" rel="stylesheet" />
  <link href="../styles/navbar.css" rel="stylesheet" />
  <link href="../styles/body.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>
<body>
  <?php include '../includes/cabecera.php'; ?>

  <main class="container py-5">
    <h2 class="mb-4 text-center">Tu carrito</h2>

    <?php if (empty($carrito)): ?>
      <p class="text-center">Tu carrito está vacío.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
          <thead class="table-light">
            <tr>
              <th>Producto</th>
              <th>Precio</th>
              <th style="width: 100px;">Cantidad</th>
              <th>Subtotal</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $total = 0;
              foreach ($carrito as $prod):
                $subtotal = $prod['precio'] * $prod['cantidad'];
                $total += $subtotal;
            ?>
            <tr>
              <td class="d-flex align-items-center">
                <img src="<?= htmlspecialchars($prod['imagen']) ?>" alt="<?= htmlspecialchars($prod['nombre']) ?>" width="60" class="me-3" />
                <?= htmlspecialchars($prod['nombre']) ?>
              </td>
              <td><?= number_format($prod['precio'], 2) ?> €</td>
              <td>
                <form method="POST" action="../controller/aniadir_carrito.php" style="margin:0;">
                  <input type="hidden" name="update" value="1" />
                  <input type="hidden" name="idProducto" value="<?= $prod['id'] ?>" />
                  <input 
                    type="number" 
                    name="cantidad" 
                    value="<?= $prod['cantidad'] ?>" 
                    min="0" 
                    class="form-control" 
                    onchange="this.form.submit()" 
                  />
                </form>
              </td>
              <td><?= number_format($subtotal, 2) ?> €</td>
              <td>
                <a href="../controller/aniadir_carrito.php?remove=<?= $prod['id'] ?>" class="btn btn-danger btn-sm">
                  <i class="bi bi-trash"></i> Eliminar
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="text-end">
        <h4>Total: <?= number_format($total, 2) ?> €</h4>
      </div>
    <?php endif; ?>

    <div class="text-end mt-4">
      <button class="btn btn-success">Finalizar compra</button>
    </div>
  </main>

  <?php include '../includes/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

