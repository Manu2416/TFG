<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../view/iniciarsesion.php");
    exit;
}

require_once "../model/conexion.php";
require_once "../model/clases.php";

$bd = new BD();
$conexion = $bd->iniciar_Conexion();

// Procesar edición de producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_id'])) {
    $id = (int)$_POST['editar_id'];
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = (float)$_POST['precio'];
    $precio_puntos = (int)$_POST['precio_puntos'];
    $stock = (int)$_POST['stock'];
    $tipo_id = (int)$_POST['tipo_id'];

    // Obtener imagen actual
    $productoActual = Producto::obtenerPorId($conexion, $id);
    $imagen = $productoActual['imagen'];

    // Si se sube una nueva imagen
    if (!empty($_FILES['imagen']['name'])) {
        $nombreImagen = basename($_FILES['imagen']['name']);
        $rutaDestino = "../images/" . $nombreImagen;
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $imagen = $nombreImagen;
        }
    }

    // Actualizar el producto
    $stmt = $conexion->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, precio_puntos = ?, imagen = ?, stock = ?, tipo_id = ? WHERE id = ?");
    $stmt->execute([$nombre, $descripcion, $precio, $precio_puntos, $imagen, $stock, $tipo_id, $id]);
}

$productos = Producto::obtenerTodos($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Productos</title>
    <link href="../styles/body.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2 class="mb-4">Gestión de Productos</h2>

        <a href="../view/crearProducto_admin.php" class="btn btn-success mb-3">Añadir nuevo producto</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Puntos</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="editar_id" value="<?= $producto['id'] ?>">
                            <td><input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>"></td>
                            <td><input type="text" name="descripcion" class="form-control" value="<?= htmlspecialchars($producto['descripcion']) ?>"></td>
                            <td><input type="number" step="0.01" name="precio" class="form-control" value="<?= $producto['precio'] ?>"></td>
                            <td><input type="number" name="precio_puntos" class="form-control" value="<?= $producto['precio_puntos'] ?>"></td>
                            <td><input type="number" name="stock" class="form-control" value="<?= $producto['stock'] ?>"></td>
                            <td>
                                <img src="../images/<?= $producto['imagen'] ?>" width="50" alt="Imagen actual"><br>
                                <input type="file" name="imagen" class="form-control mt-1">
                            </td>
                            <td>
                                <select name="tipo_id" class="form-select mb-2">
                                    <option value="1" <?= $producto['tipo_id'] == 1 ? 'selected' : '' ?>>Accesorio</option>
                                    <option value="2" <?= $producto['tipo_id'] == 2 ? 'selected' : '' ?>>Producto</option>
                                    <option value="3" <?= $producto['tipo_id'] == 3 ? 'selected' : '' ?>>Pack</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-success mb-1">Guardar</button>
                                <a href="../controller/borrarProducto.php?id=<?= $producto['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este producto?')">Eliminar</a>

                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="panel.php" class="btn btn-secondary mt-3">Volver al panel</a>
    </div>
</body>
</html>
