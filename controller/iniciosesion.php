<?php
session_start();
require_once "../model/conexion.php";
require_once "../model/clases.php";

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

        $usuario = new Usuario("", "", "", "", null);

        if ($usuario->IniciarSesion($conexion, $pass, $email)) {
            $_SESSION["usuario"] = [
                "id" => $usuario->getId(),
                "nombre" => $usuario->getNombre(),
                "email" => $usuario->getEmail(),
                "puntos" => $usuario->getPuntos(),
                "fecha_nacimiento" => $usuario->getFechaNacimiento(),
                "codigo_inv" => $usuario->getCodigo_inv(),
                "rol" => $usuario->getRol()
            ];

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
    $_SESSION["error_login"] = "Faltan datos.";
    header("Location: ../view/iniciarsesion.php");
    exit();
}
?>


