<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro | Ecoffe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos propios -->
    <link href="../styles/footer.css" rel="stylesheet">
    <link href="../styles/navbar.css" rel="stylesheet">
    <link href="../styles/body.css" rel="stylesheet">
    <link href="../styles/form.css" rel="stylesheet">
    <!-- Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

  <?php include '../includes/cabecera.php'; ?>
   <?php
  $alerta = "";

  if (!empty($_SESSION["error_login"])) {
      $alerta = '
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
          ' .($_SESSION["error_login"]) . '
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>';
      unset($_SESSION["error_login"]);
  } 
   if (!empty($_SESSION["error"])) {
      $alerta = '
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
          ' .($_SESSION["error"]) . '
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>';
      unset($_SESSION["error"]);
  } 
  
  ?>
  <main class="container container-form">
    <?= $alerta ?>
    <form action="../controller/iniciosesion.php" method="POST" class="form-registro p-4">
      <h2 class="mb-4 text-center form-title">INICIAR SESIÓN</h2>

      <label for="email" class="form-label">Correo electrónico</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu Correo">

      <label for="password" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="pass" name="pass" placeholder="Ingresa tu Contraseña">

      <button type="submit" class="form-btn">Iniciar Sesión</button>
      <p class="form-text ">¿Aún no te has registrado? <a href="./registrate.php" class="form-text--link">Regístrate Aquí</a></p>
    </form>
</main>
<?php include '../includes/footer.php';?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
