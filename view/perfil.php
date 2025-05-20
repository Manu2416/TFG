<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Estilos propios -->
    <link href="../styles/footer.css" rel="stylesheet">
    <link href="../styles/navbar.css" rel="stylesheet">
    <link href="../styles/body.css" rel="stylesheet">
    <link href="../styles/productos.css" rel="stylesheet">
   
    <!-- Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Perfil</title>
</head>
<body>
    <?php include '../includes/cabecera.php'; ?>
   <main class="container text-center my-5">
    <h2>Hola <?= $_SESSION['usuario']['nombre']; ?></h2>
    <h3 class="mt-4">Tus pedidos</h3>

    <div class="row justify-content-center mt-4">
        <?php
        if (!empty($pedidos)) {
            foreach ($pedidos as $pedido) {
                ?>
                <div class="col-md-4 mb-3">
                    <div class="card shadow rounded-4">
                        <div class="card-body">
                            <h5 class="card-title">Pedido #<?= $pedido['id'] ?></h5>
                            <p class="card-text"><strong>Fecha:</strong> <?= $pedido['fecha'] ?></p>
                            <p class="card-text"><strong>Total:</strong> <?= number_format($pedido['total'], 2) ?> €</p>
                            <p class="card-text"><strong>Puntos ganados:</strong> <?= $pedido['puntos'] ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No tienes pedidos todavía.</p>";
        }
        ?>
    </div>

    <!-- Botón de cerrar sesión -->
    <form action="../controller/cerrarsesion.php" method="POST" class="mt-5">
        <button type="submit" class="btn btn-danger px-4 py-2">Cerrar sesión</button>
    </form>
</main>

    <?php include '../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>