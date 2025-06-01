<?php
/**
 * Inicio de sesión de usuarios
 * 
 * Este script procesa el formulario de inicio de sesión, verifica credenciales
 * y establece la sesión del usuario si los datos son válidos.
 * 
 * PHP version 7+
 * 
 * @category Autenticacion
 * @package  SistemaUsuariosLoginAdminCliente
 * @author   Manuel Garcia
 * @license  MIT
 * @version  1.0
 */

session_start();

require_once "../model/conexion.php";
require_once "../model/clases.php";

// -----------------------------------------------------------------------------
// Validación de campos obligatorios del formulario
// -----------------------------------------------------------------------------

if (
    isset($_POST["email"], $_POST["pass"]) &&
    !empty(trim($_POST["email"])) &&
    !empty($_POST["pass"])
) {
    $email = trim($_POST["email"]);
    $pass = $_POST["pass"];

    try {
        $bd = new BD();
        $conexion = $bd->iniciar_Conexion();

        // Se crea una instancia de Usuario sin datos iniciales (solo para autenticar)
        $usuario = new Usuario("", "", "", "", null);

        /**
         * Verifica las credenciales del usuario.
         * 
         * @param PDO    $conexion Conexión a la base de datos
         * @param string $pass     Contraseña ingresada
         * @param string $email    Email ingresado
         * 
         * @return bool true si el usuario es válido, false si no
         */
        if ($usuario->IniciarSesion($conexion, $pass, $email)) {
            // Datos del usuario recuperados y almacenados en la sesión
            $_SESSION["usuario"] = [
                "id"               => $usuario->getId(),
                "nombre"           => $usuario->getNombre(),
                "email"            => $usuario->getEmail(),
                "puntos"           => $usuario->getPuntos(),
                "fecha_nacimiento" => $usuario->getFechaNacimiento(),
                "codigo_inv"       => $usuario->getCodigo_inv(),
                "rol"              => $usuario->getRol()
            ];

            // Redirección basada en el rol del usuario
            if ($usuario->getRol() === 'admin') {
                header("Location: ../view/panel.php");
            } else {
                header("Location: ../view/inicio.php");
            }
            exit();

        } else {
            $_SESSION["error_login"] = "Email o contraseña incorrectos.";
            header("Location: ../view/iniciarsesion.php");
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION["error_login"] = "Error en la base de datos: " . $e->getMessage();
        header("Location: ../view/iniciarsesion.php");
        exit();
    }

} else {
    // Faltan campos obligatorios
    $_SESSION["error_login"] = "Faltan datos.";
    header("Location: ../view/iniciarsesion.php");
    exit();
}
?>


