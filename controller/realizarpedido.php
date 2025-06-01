<?php
/**
 * Procesar pedido - Controlador de compra
 * 
 * Este script procesa la compra de los productos agregados al carrito,
 * crea un pedido, guarda los detalles y actualiza los puntos del usuario.
 * Utiliza una transacción para garantizar la consistencia de los datos.
 * 
 * PHP version 7+
 * 
 * @category Controlador
 * @package  CarritoDeCompras_Pedidos_Puntos
 * @author   Manuel Garcia
 * @license  MIT
 * @version  1.0
 */

session_start();

require_once "../model/conexion.php";
require_once "../model/clases.php";

// -----------------------------------------------------------------------------
// Verificación de usuario autenticado y carrito no vacío
// -----------------------------------------------------------------------------

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

    /**
     * Crea un nuevo pedido en la base de datos.
     * 
     * @param int   $usuarioId ID del usuario que realiza el pedido
     * @param array $carrito   Lista de productos y cantidades
     * 
     * @return int ID del pedido recién creado
     */
    $pedidoId = $pedidoObj->crearPedido($usuarioId, $carrito);

    /**
     * Guarda los detalles de productos asociados al pedido.
     * 
     * @param int   $pedidoId ID del pedido
     * @param array $carrito  Detalles de los productos
     * 
     * @return void
     */
    $detalleObj->guardarDetalles($pedidoId, $carrito);

  
    // Cálculo de puntos ganados (1 punto por cada unidad monetaria gastada)
  

    $total = 0;
    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    $puntosGanados = floor($total);

  
    // Actualización de puntos del usuario
  

    $stmtPuntos = $conexion->prepare("UPDATE usuarios SET puntos = puntos + ? WHERE id = ?");
    $stmtPuntos->execute([$puntosGanados, $usuarioId]);

    // Reflejar el cambio de puntos en la sesión del usuario
    $_SESSION['usuario']['puntos'] += $puntosGanados;

    $conexion->commit();

    // Eliminar carrito de la sesión tras finalizar el pedido
    unset($_SESSION['carrito']);

    // Redirige a página de agradecimiento
    header("Location: ../view/gracias.php?pedido_id=$pedidoId");
    exit;

} catch (Exception $e) {
    // En caso de error, revierte todos los cambios
    $conexion->rollBack();
    error_log("Error al realizar el pedido: " . $e->getMessage());

    header("Location: ../view/carrito.php?error=1");
    exit;
}
?>

