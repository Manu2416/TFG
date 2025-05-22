<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../view/login.php");
    exit;
}

require_once "../model/conexion.php";

$usuarioId = $_SESSION['usuario']['id'];

$bd = new BD();
$conexion = $bd->iniciar_Conexion();

// Obtener pedidos del usuario
$stmt = $conexion->prepare("SELECT id, fecha, total, puntos_ganados as puntos FROM pedidos WHERE usuario_id = ? ORDER BY fecha DESC");
$stmt->execute([$usuarioId]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consultar código de invitación actualizado desde la BD
$stmt = $conexion->prepare("SELECT codigo_inv FROM usuarios WHERE id = ?");
$stmt->execute([$usuarioId]);
$codigoInv = $stmt->fetchColumn();

if ($codigoInv) {
    $_SESSION['usuario']['codigo_inv'] = $codigoInv;
} else {
    $_SESSION['usuario']['codigo_inv'] = 'Código no disponible';
}
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
    <h3 class="mt-4">Tus Codigo de invitación</h3>
    <div class="d-flex align-items-center">
        <span id="codigoInv"><?= htmlspecialchars($_SESSION['usuario']['codigo_inv']); ?></span>
        <button onclick="copiarCodigo()" class="btn btn-primary btn-sm ms-2"><i class="bi bi-copy"></i></button>
    </div>
   <h3 class="mt-4">Tus pedidos</h3>

    <div class="row justify-content-center mt-4">
        <?php
        if (!empty($pedidos)) {
            foreach ($pedidos as $pedido) {
                ?>
                <div class="col-md-4 mb-3">
                    <div class="card shadow rounded-4">
                        <div class="card-body">
                            <h5 class="card-title">Pedido #<?= htmlspecialchars($pedido['id']) ?></h5>
                            <p class="card-text"><strong>Fecha:</strong> <?= htmlspecialchars($pedido['fecha']) ?></p>
                            <p class="card-text"><strong>Total:</strong> <?= number_format($pedido['total'], 2) ?> €</p>
                            <p class="card-text"><strong>Puntos ganados:</strong> <?= htmlspecialchars($pedido['puntos']) ?></p>
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
    <script src="../scripts/copiar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>