<?php
require_once "conexion.php";

class Usuario {
    private ?int $id = null;  
    private string $nombre;
    private string $email;
    private string $rol;
    private string $pass;
    private string $fecha_nacimiento;
    private int $puntos;
    private ?int $referido_por;
    private string $codigo_inv;

    public function __construct($nombre, $email, $pass, $fecha_nacimiento, $referido_por = null,$rol = "usuario") {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->pass = $pass;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->puntos = 0;
        $this->referido_por = $referido_por;
         $this->rol = $rol;
        $this->codigo_inv = $this->generarCodigoInv();
    }
    // Generamos un codigo de inv aleatorio
    private function generarCodigoInv($length = 8){
        $cod = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo = '';
        for ($i = 0; $i < $length; $i++) {
            $codigo .= $cod[random_int(0, strlen($cod) - 1)];
        }
        return $codigo;
    }

    // Todos los Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPuntos() {
        return $this->puntos;
    }

    public function getFechaNacimiento() {
        return $this->fecha_nacimiento;
    }
       public function getCodigo_inv() {
        return $this->codigo_inv;
    }
    public function getRol() {
        return $this->rol;
    }
    // Registramos Usuarios
    public function RegistrarUsuario(PDO $conexion) {
        $hashedPass = password_hash($this->pass, PASSWORD_BCRYPT);
        $consulta = $conexion->prepare(
            "INSERT INTO usuarios (nombre, email, pass, fecha_nacimiento, puntos, referido_por, codigo_inv, rol) 
             VALUES (?, ?, ?, ?, 0, ?, ?, ?)"
        );
        $resultado = $consulta->execute([
            $this->nombre,
            $this->email,
            $hashedPass,
            $this->fecha_nacimiento,
            $this->referido_por,
            $this->codigo_inv,
            $this->rol
        ]);

        if ($resultado) {
            $this->id = (int) $conexion->lastInsertId();
        }

        return $resultado;
    }
    // Iniciamos sesion
    public function IniciarSesion(PDO $conexion, $pass, $email) {
        $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
        $consulta->execute([$email]);

        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($pass, $usuario["pass"])) {
            $this->id = (int)$usuario["id"];
            $this->nombre = $usuario["nombre"];
            $this->email = $usuario["email"];
            $this->pass = $usuario["pass"];
            $this->fecha_nacimiento = $usuario["fecha_nacimiento"];
            $this->puntos = (int)$usuario["puntos"];
            $this->referido_por = $usuario["referido_por"] !== null ? (int)$usuario["referido_por"] : null;
            $this->codigo_inv = $usuario["codigo_inv"];
            $this->rol = $usuario['rol'];
            return true;
        } else {
            return false;
        }
    }
    // Obtiene todos los usuarios
    public static function obtenerTodos(PDO $conexion) {
        $consulta = $conexion->query("SELECT id, nombre, email, rol FROM usuarios");
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cogemos el cod_inv
    public static function obtenerIdPorCodigo(PDO $conexion, $codigo): ?int {
        $consulta = $conexion->prepare("SELECT id FROM usuarios WHERE codigo_inv = ?");
        $consulta->execute([$codigo]);
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado ? (int)$resultado['id'] : null;
    }
    // Sumamos puntos al invitar
    public static function sumarPuntos($conexion, $usuarioId, $cantidad) {
        $sql = "UPDATE usuarios SET puntos = puntos + ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        return $stmt->execute([$cantidad, $usuarioId]);
    }
    // Restar puntos 
    public static function restarPuntos(PDO $conexion, $usuarioId,$cantidad): bool {
    $sql = "UPDATE usuarios SET puntos = puntos - ? WHERE id = ? AND puntos >= ?";
    $stmt = $conexion->prepare($sql);
    return $stmt->execute([$cantidad, $usuarioId, $cantidad]);
}

}
class Producto {
    private string $nombre;
    private string $descripcion;
    private float $precio;
    private int $precio_puntos;
    private string $imagen;
    private int $stock;
    private int $tipo_id;

    public function __construct($nombre, $descripcion, $precio, $precio_puntos, $imagen, $stock, $tipo_id) {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->precio_puntos = $precio_puntos;
        $this->imagen = $imagen;
        $this->stock = $stock;
        $this->tipo_id = $tipo_id;
    }

    // Guardar un nuevo producto
    public function guardar(PDO $conexion): bool {
        $consulta = $conexion->prepare("INSERT INTO productos (nombre, descripcion, precio, precio_puntos, imagen, stock, tipo_id) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $consulta->execute([
            $this->nombre,
            $this->descripcion,
            $this->precio,
            $this->precio_puntos,
            $this->imagen,
            $this->stock,
            $this->tipo_id
        ]);
    }
    public static function obtenerCanjeablesPorPuntos($conexion) {
    $sql = "SELECT * FROM productos WHERE precio_puntos > 0 ORDER BY precio_puntos ASC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenemos cada tipo_producto
    public static function obtenerAccesorios($conexion) {
        $sql = "SELECT * FROM productos WHERE tipo_id = 1";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function obtenerPacks($conexion) {
        $sql = "SELECT * FROM productos WHERE tipo_id = 3";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function obtenerProductos($conexion) {
        $sql = "SELECT * FROM productos WHERE tipo_id = 2";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerPorId(PDO $conexion, $id) {
        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        return $producto ?: null;
    }

    public static function obtenerTodos(PDO $conexion) {
    $sql = "SELECT * FROM productos";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    // Actualizar stock
    public static function actualizarStock(PDO $conexion, int $id, int $nuevoStock): bool {
        $consulta = $conexion->prepare("UPDATE productos SET stock = ? WHERE id = ?");
        return $consulta->execute([$nuevoStock, $id]);
    }

    // Eliminar producto
    public static function eliminar(PDO $conexion, int $id) {
        $consulta = $conexion->prepare("DELETE FROM productos WHERE id = ?");
        return $consulta->execute([$id]);
    }
}
class Pedido {
    private PDO $conexion;

    public function __construct(PDO $conexion) {
        $this->conexion = $conexion;
    }

    public function crearPedido(int $usuarioId, array $carrito, ?string $fecha = null): int {
        try {
            $fecha = $fecha ?? date("Y-m-d H:i:s");
            $total = 0;
            foreach ($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            $puntosGanados = floor($total); 

            // Insertar pedido
            $stmt = $this->conexion->prepare("INSERT INTO pedidos (usuario_id, fecha, total, puntos_ganados) VALUES (?, ?, ?, ?)");
            $stmt->execute([$usuarioId, $fecha, $total, $puntosGanados]);

       

            return $this->conexion->lastInsertId(); 
        } catch (PDOException $e) {
            die("Error al crear el pedido: " . $e->getMessage());
        }
    }


    public function obtenerPorId(int $id): ?array {
        $sql = "SELECT * FROM pedidos WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
        return $pedido ?: null;
    }
}

class DetallePedido {
    private PDO $conexion;

    public function __construct(PDO $conexion) {
        $this->conexion = $conexion;
    }

    // Guarda todos los productos del carrito como detalles de un pedido
    public function guardarDetalles(int $pedidoId, array $carrito): void {
        $stmt = $this->conexion->prepare(
            "INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio_unitario)
             VALUES (?, ?, ?, ?)"
        );

        foreach ($carrito as $item) {
            $stmt->execute([
                $pedidoId,
                $item['id'],
                $item['cantidad'],
                $item['precio']
            ]);
        }
    }

    // Obtiene todos los detalles de un pedido dado su ID
    public function obtenerPorPedidoId(int $pedidoId): array {
        $stmt = $this->conexion->prepare(
            "SELECT dp.*, p.nombre, p.imagen 
             FROM detalle_pedido dp
             JOIN productos p ON dp.producto_id = p.id
             WHERE dp.pedido_id = ?"
        );
        $stmt->execute([$pedidoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>
