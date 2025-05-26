<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../view/iniciarsesion.php");
    exit;
}

require_once "../model/conexion.php";
require_once "../model/clases.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        $bd = new BD();
        $conexion = $bd->iniciar_Conexion();

        if (Producto::eliminar($conexion, $id)) {
            $_SESSION['mensaje'] = "Producto eliminado correctamente.";
        } else {
            $_SESSION['error'] = "No se pudo eliminar el producto.";
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al conectar con la base de datos: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "ID inválido.";
}

header("Location: ../view/productos_admin.php");
exit;
