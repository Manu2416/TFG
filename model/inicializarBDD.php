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
    codigo_inv varchar(10),
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

$consulta = "INSERT INTO usuarios (nombre, email, pass, fecha_nacimiento, puntos, rol,codigo_inv)
VALUES ('admin', 'admin@admin.com', '$contraAdmin', '2000-01-01', 0, 'admin','codigoinv')";


try {
    $pdo->exec($consulta);
} catch (PDOException $e) {
    echo "Error insertando admin: " . $e->getMessage();
}

$consulta = "INSERT INTO tipo_producto (nombre) VALUES 
('Accesorios'),
('Café'),
('Packs'),
('Premios');
";
try {
    $pdo->exec($consulta);
} catch (PDOException $e) {
    echo "Error al insertar los tipo_producto " . $e->getMessage();
}
$consultaaccesorio = "INSERT INTO productos (nombre, descripcion, precio, precio_puntos, imagen, stock, tipo_id) VALUES
('Termo', 'Termo de acero inoxidable que mantiene el calor.', 15.00, 150, '../images/termo_cafe.jpg', 20, 1),
('Soporte para Taza', 'Soporte de madera con diseño minimalista.', 12.00, 120, '../images/soporte_taza.jpg', 25, 1),
('Molinillo de Café Manual', 'Molinillo ajustable de acero inoxidable.', 20.00, 200, '../images/molinillo.jpg', 15, 1);";

try {
    $pdo->exec($consultaaccesorio);
} catch (PDOException $e) {
    echo "Error al insertar los accesorios: " . $e->getMessage();
}

$consultaCafe = "INSERT INTO productos (nombre, descripcion, precio, precio_puntos, imagen, stock, tipo_id) VALUES
('Cápsulas Premium 100% Arábica', 'Cápsulas biodegradables con café arábica de tueste medio.', 8.90, 89, '../images/cafe_capsula1', 50, 2),
('Cápsulas Intensidad Alta', 'Cápsulas biodegradables con mezcla intensa de granos seleccionados.', 12.50, 125, '../images/cafe_capsula2', 40, 2),
('Cápsulas Descafeinado Natural', 'Cápsulas biodegradables sin cafeína, sabor suave y equilibrado.', 7.90, 79, '../images/cafe_capsula3', 35, 2),
('Cápsulas Edición Especial', 'Cápsulas biodegradables con café de origen único en edición limitada.', 10.50, 105, '../images/cafe_capsula4', 20, 2);";

try {
    $pdo->exec($consultaCafe);
} catch (PDOException $e) {
    echo "Error al insertar productos de café: " . $e->getMessage();
}
$consultaPacks = "INSERT INTO productos (nombre, descripcion, precio, precio_puntos, imagen, stock, tipo_id) VALUES
('Pack Degustación x4', 'Incluye 4 variedades de café en sobres de 50g.', 16.00, 160, '../images/pack_degusta.jpg', 20, 3),
('Pack Cápsulas Intenso x10', 'Cápsulas compatibles con Nespresso.', 6.50, 65, '../images/pack_capsulas.jpg', 30, 3),
('Pack Inicio Barista', 'Taza + café molido + guía barista.', 22.00, 220, '../images/pack_barista.jpg', 15, 3),
('Pack Regalo Café Lover', 'Caja de regalo con tazas, café y accesorios.', 30.00, 300, '../images/pack_regalo.jpg', 10, 3);";

try {
    $pdo->exec($consultaPacks);
} catch (PDOException $e) {
    echo "Error al insertar productos de packs: " . $e->getMessage();
}


$consultaPremios = "INSERT INTO productos (nombre, descripcion, precio, precio_puntos, imagen, stock, tipo_id) VALUES
('Set Ecoffee Básico', 'Incluye taza reutilizable Ecoffee y muestra de café molido.', 12.00, 120, '../images/set_basico.jpg', 25, 4),
('Mini Pack Sorpresa Café', 'Tres sobres sorpresa de café premium de distintas variedades.', 10.00, 100, '../images/pack_sorpresa.jpg', 30, 4),
('Taza Ecoffe Edición Limitada', 'Taza de cerámica con diseño exclusivo Ecoffee.', 8.50, 85, '../images/taza_edicion.jpg', 40, 4),
('Combo Ecoffee Premium', 'Taza, café gourmet y caja de regalo con diseño exclusivo.', 26.00, 260, '../images/combo_premium.jpg', 12, 4);";

try {
    $pdo->exec($consultaPremios);
} catch (PDOException $e) {
    echo "Error al insertar productos de packs: " . $e->getMessage();
}

?>
