<?php
// Datos de conexión
$host = 'localhost';
$usuario = 'root';
$contrasenia = '123';
// Datos de conexión
$host = 'localhost';
$usuario = 'root';
$contrasenia = '123';
$nombreBD = 'TFG';

try {
    // Conectamos al servidor sin especificar base de datos
    $pdoTemp = new PDO("mysql:host=$host", $usuario, $contrasenia);
    $pdoTemp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Creamos la base de datos si no existe
    $sql = "CREATE DATABASE IF NOT EXISTS $nombreBD CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $pdoTemp->exec($sql);
    $pdoTemp = null; // Cerramos conexión temporal
} catch (PDOException $e) {
    die("Error creando la base de datos: " . $e->getMessage());
}
try {
    // Conectamos al servidor sin especificar base de datos
    $pdoTemp = new PDO("mysql:host=$host", $usuario, $contrasenia);
    $pdoTemp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Creamos la base de datos si no existe
    $sql = "CREATE DATABASE IF NOT EXISTS $nombreBD CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $pdoTemp->exec($sql);
    $pdoTemp = null; // Cerramos conexión temporal
} catch (PDOException $e) {
    die("Error creando la base de datos: " . $e->getMessage());
}
// Llamamos a la conexión
require_once "conexion.php";

// Usamos el objeto BD e inicializamos la conexión
$bd = new BD(); 
$pdo = $bd->iniciar_Conexion();

// Tabla de usuarios
$consulta = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    pass VARCHAR(255),
    fecha_nacimiento DATE,
    puntos INT DEFAULT 0,
    rol ENUM('usuario', 'admin') DEFAULT 'usuario',
    referido_por INT,
    codigo_inv int,
    FOREIGN KEY (referido_por) REFERENCES usuarios(id)
) ENGINE=InnoDB;";

try {
    $pdo->exec($consulta);
} catch (PDOException $e) {
    echo "Error en usuarios: " . $e->getMessage();
}

// Tabla de tipo de producto (categorías)
$consulta = "CREATE TABLE IF NOT EXISTS tipo_producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion VARCHAR(255)
) ENGINE=InnoDB;";

try {
    $pdo->exec($consulta);
} catch (PDOException $e) {
    echo "Error en tipo_producto: " . $e->getMessage();
}

// Tabla de productos con precio y precio_puntos
$consulta = "CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion VARCHAR(255),
    precio DECIMAL(10,2),           
    precio_puntos INT,              
    imagen VARCHAR(255),
    stock INT DEFAULT 0,
    tipo_id INT,
    FOREIGN KEY (tipo_id) REFERENCES tipo_producto(id)
) ENGINE=InnoDB;";

try {
    $pdo->exec($consulta);
} catch (PDOException $e) {
    echo "Error en productos: " . $e->getMessage();
}

// Tabla de pedidos
$consulta = "CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2),
    puntos_ganados INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;";

try {
    $pdo->exec($consulta);
} catch (PDOException $e) {
    echo "Error en pedidos: " . $e->getMessage();
}

// Tabla de detalle_pedido
$consulta = "CREATE TABLE IF NOT EXISTS detalle_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT,
    producto_id INT,
    cantidad INT,
    precio_unitario DECIMAL(10,2),
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
) ENGINE=InnoDB;";

try {
    $pdo->exec($consulta);
} catch (PDOException $e) {
    echo "Error en detalle_pedido: " . $e->getMessage();
}

// Tabla de invitaciones
$consulta = "CREATE TABLE IF NOT EXISTS invitaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invitador_id INT,
    invitado_email VARCHAR(100),
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    usado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (invitador_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;";

try {
    $pdo->exec($consulta);
} catch (PDOException $e) {
    echo "Error en invitaciones: " . $e->getMessage();
}

// Inserto un Usuario admin tras crear todo
$admin = "admin";
$contraAdmin = password_hash($admin, PASSWORD_BCRYPT);

$consulta = "INSERT INTO usuarios (nombre, email, pass, fecha_nacimiento, puntos, rol)
VALUES ('admin', 'admin@admin.com', '$contraAdmin', '2000-01-01', 0, 'admin')";


try {
    $pdo->exec($consulta);
} catch (PDOException $e) {
    echo "Error insertando admin: " . $e->getMessage();
}
?>
