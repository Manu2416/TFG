<?php
/**
 * Eliminar producto - Controlador para administradores
 * 
 * Este script permite a los administradores eliminar productos del sistema.
 * Verifica la autenticación y el rol antes de realizar la operación.
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
    header("Location: ../view/iniciarsesion.php");
    exit;
}

require_once "../model/conexion.php";
require_once "../model/clases.php";


// Validación del parámetro 'id' y proceso de eliminación del producto


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        $bd = new BD();
        $conexion = $bd->iniciar_Conexion();

        /**
         * Intenta eliminar el producto con el ID proporcionado.
         * 
         * @param PDO $conexion Objeto de conexión a la base de datos
         * @param int $id        ID del producto a eliminar
         * 
         * @return bool true si se elimina correctamente, false en caso contrario
         */
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


// Redirección final a la vista de administración de productos


header("Location: ../view/productos_admin.php");
exit;
