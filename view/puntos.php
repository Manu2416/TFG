<?php
session_start();

// Si no hay usuario en sesión, redirigir a login
if (!isset($_SESSION['usuario'])) {
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
    <title>Ecoffe - Productos</title>
    <!-- Aquí van tus estilos y links -->
    <link href="../styles/footer.css" rel="stylesheet" />
    <link href="../styles/navbar.css" rel="stylesheet" />
    <link href="../styles/body.css" rel="stylesheet" />
    <link href="../styles/productos.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>
<body>
<?php include '../includes/cabecera.php'; ?>

<div class="container-fluid mt-3">
    <div class="row d-flex justify-content-end">
        <div class="col-auto puntos mx-5">
            <img src="../images/moneda.png" alt="Moneda" />
            <p><?= htmlspecialchars($puntos) ?></p>
        </div>
    </div>
</div>

<main class="container mb-5">
    <!-- Aquí tu contenido con productos... -->
</main>

<?php include '../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
