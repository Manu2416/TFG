<?php
require_once "conexion.php";

class Usuario {
    private string $nombre;
    private string $email;
    private string $pass;
    private string $fecha_nacimiento;
    private int $puntos;
    private ?int $referido_por;
    private string $codigo_inv;

    public function __construct($nombre, $email, $pass, $fecha_nacimiento, $referido_por = null) {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->pass = $pass;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->puntos = 0;
        $this->referido_por = $referido_por;
        $this->codigo_inv = $this->generarCodigoInv();
    }

    private function generarCodigoInv($length = 8){
      
        $cod = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo = '';
        for ($i = 0; $i < $length; $i++) {
            $codigo .= $cod[random_int(0, strlen($cod) - 1)];
        }
        return $codigo;
    }

    public function getDatos() {
        return [
            "nombre" => $this->nombre,
            "email" => $this->email,
            "pass" => $this->pass,
            "fecha_nacimiento" => $this->fecha_nacimiento,
            "puntos" => $this->puntos,
            "referido_por" => $this->referido_por,
            "codigo_inv" => $this->codigo_inv
        ];
    }

    public function RegistrarUsuario(PDO $conexion){
      
            $hashedPass = password_hash($this->pass, PASSWORD_BCRYPT);
            $consulta = $conexion->prepare(
                "INSERT INTO usuarios (nombre, email, pass, fecha_nacimiento, puntos, referido_por, codigo_inv) VALUES (?, ?, ?, ?, 0, ?, ?)"
            );
            return $consulta->execute([
                $this->nombre,
                $this->email,
                $hashedPass,
                $this->fecha_nacimiento,
                $this->referido_por,
                $this->codigo_inv
            ]);
      
    }

    public function IniciarSesion(PDO $conexion, $pass, $email) {
        $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
        $consulta->execute([$email]);

        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($pass, $usuario["pass"])) {
            $this->nombre = $usuario["nombre"];
            $this->email = $usuario["email"];
            $this->pass = $usuario["pass"];
            $this->fecha_nacimiento = $usuario["fecha_nacimiento"];
            $this->puntos = (int)$usuario["puntos"];
            $this->referido_por = $usuario["referido_por"] !== null ? (int)$usuario["referido_por"] : null;
            $this->codigo_inv = $usuario["codigo_inv"];
            return true;
        } else {
            return false;
        }
    }

    public static function obtenerIdPorCodigo(PDO $conexion, $codigo): ?int {
        $consulta = $conexion->prepare("SELECT id FROM usuarios WHERE codigo_inv = ?");
        $consulta->execute([$codigo]);
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado ? (int)$resultado['id'] : null;
    }
}
?>
