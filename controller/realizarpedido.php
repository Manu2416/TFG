<?php
session_start();
require_once "../model/conexion.php";
require_once "../model/clases.php";


if (!isset($_SESSION['usuario'])) {
    // No está logueado, no puede comprar
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

    // Crear pedido solo con usuario_id, sin datos invitados
    $pedidoId = $pedidoObj->crearPedido($usuarioId, $carrito);

    $detalleObj->guardarDetalles($pedidoId, $carrito);

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