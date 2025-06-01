<?php 
session_start(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
     <!-- Estilos propios -->
    <link href="../styles/body.css" rel="stylesheet">
    <!-- Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Crear nuevo producto</h2>


        <?php if (isset($_SESSION["creado"])): ?>
            <div class="alert alert-success">
                <?= $_SESSION["creado"]; ?>
            </div>
            <?php unset($_SESSION["creado"]); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION["error"])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION["error"]; ?>
            </div>
            <?php unset($_SESSION["error"]); ?>
        <?php endif; ?>


    <form action="../controller/crear_producto.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio (€)</label>
            <input type="number" step="0.01" name="precio" id="precio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="precio_puntos" class="form-label">Precio en puntos</label>
            <input type="number" name="precio_puntos" id="precio_puntos" class="form-control" value="0" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tipo_id" class="form-label">Tipo de producto</label>
            <select name="tipo_id" id="tipo_id" class="form-select" required>
                <option value="1">Accesorio</option>
                <option value="2">Producto</option>
                <option value="3">Pack</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" name="imagen" id="imagen" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Crear producto</button>
        <a href="../view/productos_admin.php" class="btn btn-secondary">Volver para editar o eliminar</a>
    </form>
</div>
</body>
</html>
