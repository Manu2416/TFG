<?php
session_start();
require_once "../model/conexion.php";
require_once "../model/clases.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: ../view/login.php?error=debes_login");
    exit;
}

if (empty($_SESSION['carrito'])) {
    header("Location: ../view/carrito.php?error=carrito_vacio");
    exit;
}

$usuarioId = $_SESSION['usuario']['id'];
$carrito = $_SESSION['carrito'];

$bd = new BD();
$conexion = $bd->iniciar_Conexion();

$pedidoObj = new Pedido($conexion);
$detalleObj = new DetallePedido($conexion);

try {
    $conexion->beginTransaction();

    // Crear pedido y obtener su ID
    $pedidoId = $pedidoObj->crearPedido($usuarioId, $carrito);

    // Guardar detalles del pedido
    $detalleObj->guardarDetalles($pedidoId, $carrito);

    // Calcular puntos ganados según total del pedido
    $total = 0;
    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }
    $puntosGanados = floor($total);

    // Actualizar puntos del usuario
    $stmtPuntos = $conexion->prepare("UPDATE usuarios SET puntos = puntos + ? WHERE id = ?");
    $stmtPuntos->execute([$puntosGanados, $usuarioId]);

    // Actualizar puntos en la sesión para reflejar el cambio inmediatamente
    $_SESSION['usuario']['puntos'] += $puntosGanados;

    $conexion->commit();

    unset($_SESSION['carrito']);

    header("Location: ../view/gracias.php?pedido_id=$pedidoId");
    exit;
} catch (Exception $e) {
    $conexion->rollBack();
    error_log("Error al realizar el pedido: " . $e->getMessage());
    header("Location: ../view/carrito.php?error=1");
    exit;
}
?>
