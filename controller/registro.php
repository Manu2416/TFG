<?php
session_start();
require_once "../model/conexion.php";
require_once "../model/clases.php";

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

    if (!preg_match('/^[\w\.-]+@[\w\.-]+\.\w{2,}$/', $email)) {
        $_SESSION["error"] = "Formato de correo inválido.";
        header("Location: ../view/registrate.php");
        exit();
    }

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $pass)) {
        $_SESSION["error"] = "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.";
        header("Location: ../view/registrate.php");
        exit();
    }

    try {
        $bd = new BD();
        $conexion = $bd->iniciar_Conexion();

        $referido_por = null;
        if ($codigo_inv) {
            $referido_por = Usuario::obtenerIdPorCodigo($conexion, $codigo_inv);
            if ($referido_por === null) {
                $_SESSION["error"] = "Código de invitación inválido.";
                header("Location: ../view/registrate.php");
                exit();
            }
        }

        $usuario = new Usuario($nombre, $email, $pass, $fecha_nacimiento, $referido_por);

        if ($usuario->RegistrarUsuario($conexion)) {
            $usuarioIdNuevo = $usuario->getId();

            if ($usuarioIdNuevo === null) {
                throw new Exception("No se pudo obtener el ID del usuario después del registro.");
            }
            Usuario::sumarPuntos($conexion, $usuarioIdNuevo, 50);

          
            if ($referido_por !== null) {
                Usuario::sumarPuntos($conexion, $referido_por, 100);
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
        $_SESSION["error"] = "Error: " . $e->getMessage();
        header("Location: ../view/registrate.php");
        exit();
    }
} else {
    $_SESSION["error"] = "Por favor, rellene todos los campos obligatorios.";
    header("Location: ../view/registrate.php");
    exit();
}
?>
