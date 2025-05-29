<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: iniciarsesion.php");
    exit;
}

require_once "../model/conexion.php";
require_once "../model/clases.php";

$bd = new BD();
$conexion = $bd->iniciar_Conexion();

if (isset($_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['precio_puntos'], $_POST['stock'], $_POST['tipo_id']) && !empty($_FILES['imagen']['name'])) {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = (float)$_POST['precio'];
    $precio_puntos = (int)$_POST['precio_puntos'];
    $stock = (int)$_POST['stock'];
    $tipo_id = (int)$_POST['tipo_id'];

    $nombreImagen = basename($_FILES['imagen']['name']);
    $rutaDestino = "../images/" . $nombreImagen;

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
        $imagen = $nombreImagen;

        $producto = new Producto($nombre, $descripcion, $precio, $precio_puntos, $imagen, $stock, $tipo_id);
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

header("Location: ../view/crearProducto_admin.php");
exit;
?>
