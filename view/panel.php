<?php
session_start();

// Verifica que haya sesión y que sea administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

require_once "../model/conexion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Tus estilos -->
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/body.css">
</head>
<body>

<?php include '../includes/cabecera.php'; ?>

<main class="container mt-5">
    <h1 class="text-center mb-4">Panel de Control del Administrador</h1>

    <div class="row g-4">
        <!-- Gestión de Productos -->
        <div class="col-md-6">
            <div class="card text-center shadow rounded-4">
                <div class="card-body">
                    <i class="bi bi-box-seam display-4 mb-3 text-primary"></i>
                    <h5 class="card-title">Productos</h5>
                    <p class="card-text">Añade, edita o elimina productos del catálogo.</p>
                    <a href="productos_admin.php" class="btn btn-primary">Gestionar</a>
                </div>
            </div>
        </div>

        <!-- Pedidos -->
        <div class="col-md-6">
            <div class="card text-center shadow rounded-4">
                <div class="card-body">
                    <i class="bi bi-receipt display-4 mb-3 text-warning"></i>
                    <h5 class="card-title">Pedidos</h5>
                    <p class="card-text">Revisa y administra los pedidos realizados.</p>
                    <a href="pedidos_admin.php" class="btn btn-warning text-white">Ver pedidos</a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <form action="../controller/cerrarsesion.php" method="POST">
            <button type="submit" class="btn btn-danger px-4">Cerrar sesión</button>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
