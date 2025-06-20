<?php
/**
 * Carrito de compras - Controlador
 * 
 * Este script gestiona las operaciones básicas del carrito de compras: agregar, actualizar
 * y eliminar productos desde la sesión del usuario.
 * 
 * PHP version 7+
 * 
 * @category Controlador
 * @package  CarritoDeCompras
 * @author   Manuel Garcia
 * @license  MIT
 * @version  1.0
 */

session_start();
require_once "../model/conexion.php";
require_once "../model/clases.php";

$bd = new BD();
$conexion = $bd->iniciar_Conexion();

// Inicializa el carrito en la sesión si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

/**
 * Redirige al usuario a la URL especificada en el campo 'redirect' o al carrito por defecto.
 *
 * @return void
 */
function redirigir()
{
    if (!empty($_POST['redirect'])) {
        $redirect = filter_var($_POST['redirect'], FILTER_SANITIZE_URL);
        header("Location: $redirect");
    } else {
        header("Location: ../view/carrito.php");
    }
    exit;
}


// Actualizar cantidad individual de un producto


if (isset($_POST['update']) && isset($_POST['idProducto']) && isset($_POST['cantidad'])) {
    $idProducto = (int)$_POST['idProducto'];
    $cantidad = (int)$_POST['cantidad'];

    if ($cantidad <= 0) {
        unset($_SESSION['carrito'][$idProducto]);
    } else {
        if (isset($_SESSION['carrito'][$idProducto])) {
            $_SESSION['carrito'][$idProducto]['cantidad'] = $cantidad;
        }
    }
    header("Location: ../view/carrito.php");
    exit;
}


// Añadir producto al carrito


if (isset($_POST['add'])) {
    $idProducto = (int)$_POST['add'];

    if (isset($_SESSION['carrito'][$idProducto])) {
        $_SESSION['carrito'][$idProducto]['cantidad']++;
    } else {
        $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$idProducto]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($producto) {
            $_SESSION['carrito'][$idProducto] = [
                "id" => $producto['id'],
                "nombre" => $producto['nombre'],
                "precio" => $producto['precio'],
                "cantidad" => 1,
                "imagen" => $producto['imagen']
            ];
        }
    }
    redirigir();
}


// Eliminar producto del carrito


if (isset($_POST['remove'])) {
    $idProducto = (int)$_POST['remove'];
    if (isset($_SESSION['carrito'][$idProducto])) {
        unset($_SESSION['carrito'][$idProducto]);
    }
    redirigir();
}


// Actualizar cantidades masivamente


if (isset($_POST['update']) && isset($_POST['cantidades'])) {
    foreach ($_POST['cantidades'] as $idProducto => $cantidad) {
        $cantidad = (int)$cantidad;
        if ($cantidad <= 0) {
            unset($_SESSION['carrito'][$idProducto]);
        } else {
            $_SESSION['carrito'][$idProducto]['cantidad'] = $cantidad;
        }
    }
    redirigir();
}


// Acción por defecto si no se reconoció ninguna


redirigir();
