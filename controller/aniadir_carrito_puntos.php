<?php
/**
 * Script para canjear un producto por puntos en la tienda virtual.
 * 
 * Este script valida la sesión del usuario, verifica si tiene suficientes
 * puntos para canjear un producto y, en caso afirmativo, descuenta los puntos
 * y añade el producto al carrito con precio 0.
 * 
 * Requiere:
 * - Sesión iniciada
 * - ID del producto enviado vía POST
 * 
 * Redirige a:
 * - ../view/iniciarsesion.php si no hay sesión activa
 * - ../view/puntos.php en caso de error o éxito
 * 
 * PHP version 8
 * @author Manuel garcia
 * @package Ecoffe
 * @subpackage Controladores
 */

session_start();

require_once "../model/conexion.php";
require_once "../model/clases.php";

// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../view/iniciarsesion.php");
    exit();
}

// Validar que se haya enviado el ID del producto por POST
if (!isset($_POST['producto_id'])) {
    header("Location: ../view/puntos.php");
    exit();
}

// Obtener datos necesarios
$productoId = intval($_POST['producto_id']);
$usuarioId = $_SESSION['usuario']['id'];
$usuarioPuntos = $_SESSION['usuario']['puntos'] ?? 0;

// Iniciar conexión con la base de datos
$bd = new BD();
$conexion = $bd->iniciar_Conexion();

// Obtener datos del producto
$producto = Producto::obtenerPorId($conexion, $productoId);

if (!$producto) {
    $_SESSION['error-carrito'] = "Producto no encontrado.";
    header("Location: ../view/puntos.php");
    exit();
}

$precioPuntos = $producto['precio_puntos'];

// Verificar si el usuario tiene suficientes puntos
if ($precioPuntos > $usuarioPuntos) {
    $_SESSION['error-carrito'] = "No tienes suficientes puntos para canjear este producto.";
    header("Location: ../view/puntos.php");
    exit();
}

// Restar puntos al usuario
if (!Usuario::restarPuntos($conexion, $usuarioId, $precioPuntos)) {
    $_SESSION['error-carrito'] = "Error al actualizar tus puntos.";
    header("Location: ../view/puntos.php");
    exit();
}

// Actualizar puntos en la sesión
$_SESSION['usuario']['puntos'] -= $precioPuntos;

// Añadir el producto al carrito con precio 0
$_SESSION['carrito'][$productoId] = [
    'id' => $producto['id'],
    'nombre' => $producto['nombre'],
    'precio' => 0,
    'cantidad' => 1,
    'canjeado' => true,
    'imagen' => $producto['imagen']
];

// Confirmación exitosa
$_SESSION['success-carrito'] = "Producto canjeado correctamente.";
header("Location: ../view/puntos.php");
exit();
?>
