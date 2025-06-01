<?php
/**
 * Crear producto - Controlador para administradores
 * 
 * Este script permite a los administradores registrar nuevos productos en el sistema.
 * Valida el formulario recibido por POST y gestiona la carga de imagen.
 * 
 * PHP version 7+
 * 
 * @category Controlador
 * @package  AdministracionProductos
 * @author   Manuel Garcia
 * @license  MIT
 * @version  1.0
 */

session_start();


// Verificación de acceso: solo administradores pueden ejecutar este script


if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: iniciarsesion.php");
    exit;
}

require_once "../model/conexion.php";
require_once "../model/clases.php";

$bd = new BD();
$conexion = $bd->iniciar_Conexion();


// Validación del formulario y proceso de creación del producto


if (
    isset($_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['precio_puntos'], $_POST['stock'], $_POST['tipo_id']) &&
    !empty($_FILES['imagen']['name'])
) {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = (float)$_POST['precio'];
    $precio_puntos = (int)$_POST['precio_puntos'];
    $stock = (int)$_POST['stock'];
    $tipo_id = (int)$_POST['tipo_id'];

    $nombreImagen = basename($_FILES['imagen']['name']);
    $rutaDestino = "../images/" . $nombreImagen;

    /**
     * Manejo de carga de imagen del producto.
     * Si la carga es exitosa, se intenta guardar el producto en la base de datos.
     */
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
        $imagen = $nombreImagen;

        $producto = new Producto($nombre, $descripcion, $precio, $precio_puntos, $imagen, $stock, $tipo_id);

        /**
         * Guarda el producto en la base de datos.
         * 
         * @param PDO $conexion Conexión activa a la base de datos
         * @return bool true si el producto se guarda correctamente
         */
        if ($producto->guardar($conexion)) {
            $_SESSION["creado"] = "Producto creado correctamente.";
        } else {
            $_SESSION["error"] = "Error al guardar el producto en la base de datos.";
        }

    } else {
        $_SESSION["error"] = "Error al subir la imagen.";
    }

} else {
    $_SESSION["error"] = "Todos los campos son obligatorios, incluida la imagen.";
}


// Redirección final a la vista de creación de productos


header("Location: ../view/crearProducto_admin.php");
exit;
?>
