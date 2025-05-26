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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = (float)$_POST['precio'];
    $precio_puntos = (int)$_POST['precio_puntos'];
    $stock = (int)$_POST['stock'];
    $tipo_id = (int)$_POST['tipo_id'];

    
    $imagen = '';
    if (!empty($_FILES['imagen']['name'])) {
        $nombreImagen = basename($_FILES['imagen']['name']);
        $rutaDestino = "../images/" . $nombreImagen;
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $imagen = $nombreImagen;
        } else {
                $_SESSION["error"]= "Error al subir la imagen.";
        }
    } else {
            $_SESSION["error"]= "Debe subir una imagen.";
    }

   if (!$error) {
    $producto = new Producto($nombre, $descripcion, $precio, $precio_puntos, $imagen, $stock, $tipo_id);
    if ($producto->guardar($conexion)) {
         $_SESSION["creado"]= "creado correctamente";
        header("Location: ../view/productos_admin.php"); 
        exit;
    } else {
       $_SESSION["error"] = "Error al guardar el producto en la base de datos.";
    }
}
 else {
       $_SESSION["error"] = "rellena los campos";
    }

}
?>