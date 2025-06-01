<?php
/**
 * Registro de usuarios
 * 
 * Este script procesa el formulario de registro, valida los datos ingresados,
 * crea un nuevo usuario en la base de datos y maneja el sistema de referidos
 * con asignación de puntos.
 * 
 * PHP version 7+
 * 
 * @category Autenticacion
 * @package  RegistroUsuariosConInvitacionYPuntos
 * @author   Manuel Garcia
 * @license  MIT
 * @version  1.0
 */

session_start();

require_once "../model/conexion.php";
require_once "../model/clases.php";

// -----------------------------------------------------------------------------
// Validación básica del formulario (campos obligatorios)
// -----------------------------------------------------------------------------

if (
    isset($_POST["nombre"], $_POST["email"], $_POST["pass"], $_POST["fecha_nacimiento"]) &&
    !empty(trim($_POST["nombre"])) &&
    !empty(trim($_POST["email"])) &&
    !empty($_POST["pass"]) &&
    !empty($_POST["fecha_nacimiento"])
) {
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $pass = $_POST["pass"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $codigo_inv = isset($_POST["codigo"]) ? trim($_POST["codigo"]) : null;

    // -------------------------------------------------------------------------
    // Validación de formato de correo
    // -------------------------------------------------------------------------
    if (!preg_match('/^[\w\.-]+@[\w\.-]+\.\w{2,}$/', $email)) {
        $_SESSION["error"] = "Formato de correo inválido.";
        header("Location: ../view/registrate.php");
        exit();
    }

    // -------------------------------------------------------------------------
    // Validación de seguridad de contraseña
    // Al menos 8 caracteres, 1 mayúscula, 1 minúscula, 1 número y 1 símbolo
    // -------------------------------------------------------------------------
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $pass)) {
        $_SESSION["error"] = "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.";
        header("Location: ../view/registrate.php");
        exit();
    }

    try {
        $bd = new BD();
        $conexion = $bd->iniciar_Conexion();

        // ---------------------------------------------------------------------
        // Verificar si el código de invitación existe (si fue enviado)
        // ---------------------------------------------------------------------
        $referido_por = null;
        if ($codigo_inv) {
            $referido_por = Usuario::obtenerIdPorCodigo($conexion, $codigo_inv);
            if ($referido_por === null) {
                $_SESSION["error"] = "Código de invitación inválido.";
                header("Location: ../view/registrate.php");
                exit();
            }
        }

        // Crear nuevo usuario
        $usuario = new Usuario($nombre, $email, $pass, $fecha_nacimiento, $referido_por);

        /**
         * Intenta registrar al nuevo usuario.
         * 
         * @param PDO $conexion Conexión activa a la base de datos
         * 
         * @return bool true si el usuario se registró correctamente
         */
        if ($usuario->RegistrarUsuario($conexion)) {
            $usuarioIdNuevo = $usuario->getId();

            if ($usuarioIdNuevo === null) {
                throw new Exception("No se pudo obtener el ID del usuario después del registro.");
            }

            // -----------------------------------------------------------------
            // Sistema de puntos por referido
            // -----------------------------------------------------------------
            if ($referido_por !== null) {
                Usuario::sumarPuntos($conexion, $usuarioIdNuevo, 50);      // Al nuevo usuario
                Usuario::sumarPuntos($conexion, $referido_por, 100);       // Al referidor
            }

            $_SESSION["correcto"] = "¡Usuario registrado correctamente!";
            header("Location: ../view/registrate.php");
            exit();

        } else {
            $_SESSION["error"] = "Error al registrarse, intente nuevamente.";
            header("Location: ../view/registrate.php");
            exit();
        }

    } catch (Exception $e) {
        // Posible error por correo duplicado u otro fallo
        $_SESSION["error"] = "email duplicado";
        header("Location: ../view/registrate.php");
        exit();
    }

} else {
    // Faltan campos obligatorios
    $_SESSION["error"] = "Por favor, rellene todos los campos obligatorios.";
    header("Location: ../view/registrate.php");
    exit();
}
?>
