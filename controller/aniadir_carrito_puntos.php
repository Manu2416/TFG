<?php
session_start();
require_once "../model/conexion.php";
require_once "../model/clases.php";

// Validar sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../view/iniciarsesion.php");
    exit();
}

if (!isset($_POST['producto_id'])) {
    header("Location: ../view/puntos.php");
    exit();
}

$productoId = intval($_POST['producto_id']);
$usuarioId = $_SESSION['usuario']['id'];
$usuarioPuntos = $_SESSION['usuario']['puntos'] ?? 0;

$bd = new BD();
$conexion = $bd->iniciar_Conexion();

// Obtener producto
$producto = Producto::obtenerPorId($conexion, $productoId);

if (!$producto) {
    $_SESSION['error-carrito'] = "Producto no encontrado.";
    header("Location: ../view/puntos.php");
    exit();
}

$precioPuntos = $producto['precio_puntos'];

if ($precioPuntos > $usuarioPuntos) {
    $_SESSION['error-carrito'] = "No tienes suficientes puntos para canjear este producto.";
    header("Location: ../view/puntos.php");
    exit();
}

// Restar puntos en la base de datos
if (!Usuario::restarPuntos($conexion, $usuarioId, $precioPuntos)) {
    $_SESSION['error-carrito'] = "Error al actualizar tus puntos.";
    header("Location: ../view/puntos.php");
    exit();
}

// Actualizar puntos en la sesión
$_SESSION['usuario']['puntos'] -= $precioPuntos;

// Añadir al carrito con precio 0
$_SESSION['carrito'][$productoId] = [
    'id' => $producto['id'],
    'nombre' => $producto['nombre'],
    'precio' => 0,
    'cantidad' => 1,
    'canjeado' => true,
    'imagen' => $producto['imagen']
];

$_SESSION['success-carrito'] = "Producto canjeado correctamente.";
header("Location: ../view/puntos.php");
exit();
