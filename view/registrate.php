<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
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

  <main class="container container-form">
  <?php
  $alerta = "";

  if (!empty($_SESSION["error"])) {
      $alerta = '
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
          ' . htmlspecialchars($_SESSION["error"]) . '
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>';
      unset($_SESSION["error"]);
  } elseif (!empty($_SESSION["correcto"])) {
      $alerta = '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          ' . htmlspecialchars($_SESSION["correcto"]) . '
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>';
      unset($_SESSION["correcto"]);
  }
  
  ?>
  <?= $alerta ?>

    <form action="../controller/registro.php" method="POST" class="form-registro p-4">
      <h2 class="mb-4 text-center form-title">REGÍSTRATE</h2>

      <label for="nombre" class="form-label">Nombre de Usuario</label>
      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Inserta tu Nombre">

      <label for="email" class="form-label">Correo electrónico</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Ej: correo@gmail.com">

      <label for="password" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="password" name="pass" placeholder="Ingresa tu Contraseña">

      <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
      <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">

      <label for="codigo" class="form-label">Código de invitación</label>
      <input type="text" class="form-control" id="codigo" name="codigo">
      <div class="form-text">Si alguien te invitó, introduce su código para obtener una recompensa.</div>

      <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="privacyCheck" required>
          <label class="form-check-label" for="privacyCheck">
              Acepto los <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal" class="form-text--link">términos y condiciones</a> y la
              <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal" class="form-text--link">política de privacidad</a>.
          </label>
      </div>
      <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Términos y Condiciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                <h3>Última actualización: abril de 2025</h3>
        
        <p>Estos Términos y Condiciones ("Términos") rigen el uso de la tienda en línea de Ecoffe, disponible a través de nuestro sitio web (en adelante, "el Sitio"). Al acceder y utilizar el Sitio, aceptas cumplir con estos Términos. Si no estás de acuerdo con alguno de estos Términos, no utilices el Sitio.</p>

        <h4>1. Aceptación de los Términos</h4>
        <p>Al utilizar el Sitio, confirmas que has leído, comprendido y aceptado estos Términos y Condiciones. Ecoffe se reserva el derecho de modificar estos Términos en cualquier momento, y dichas modificaciones entrarán en vigor inmediatamente después de su publicación en el Sitio.</p>

        <h4>2. Uso del Sitio</h4>
        <p>Ecoffe otorga a los usuarios una licencia limitada, no exclusiva, intransferible y revocable para acceder y utilizar el Sitio con fines personales y no comerciales. El usuario se compromete a no usar el Sitio para actividades ilegales, fraudulentas o maliciosas.</p>

        <h4>3. Cuenta de Usuario</h4>
        <p>Para realizar compras en el Sitio, los usuarios deben registrarse y crear una cuenta. El usuario es responsable de mantener la confidencialidad de sus credenciales de acceso y de todas las actividades realizadas bajo su cuenta. Ecoffe no será responsable por el uso no autorizado de la cuenta del usuario.</p>

        <h4>4. Productos y Precios</h4>
        <p>Ecoffe se esfuerza por ofrecer productos de alta calidad. Sin embargo, nos reservamos el derecho de modificar los precios y la disponibilidad de los productos sin previo aviso. Los precios que aparecen en el Sitio incluyen impuestos, salvo que se indique lo contrario.</p>

        <h4>5. Métodos de Pago</h4>
        <p>El Sitio acepta diversos métodos de pago, incluyendo tarjetas de crédito y PayPal. El pago se procesa a través de plataformas seguras y encriptadas para garantizar la seguridad de las transacciones.</p>

        <h4>6. Envíos y Entregas</h4>
        <p>Ecoffe se compromete a procesar y enviar los pedidos en el menor tiempo posible. Los tiempos de entrega pueden variar según la ubicación del usuario. Los costos de envío serán calculados al momento de realizar la compra y se mostrarán en el proceso de pago.</p>

        <h4>7. Política de Devoluciones</h4>
        <p>Si no estás satisfecho con tu compra, puedes devolver los productos dentro de un plazo de 14 días desde la fecha de recepción, siempre que los productos estén en su estado original, sin uso y en su embalaje original. Los productos no son retornables si se han abierto o usado.</p>

        <h4>8. Responsabilidad</h4>
        <p>Ecoffe no será responsable por daños directos, indirectos, incidentales o consecuentes que resulten del uso del Sitio o de la compra de productos. Esto incluye, pero no se limita a, daños por pérdida de datos o beneficios, interrupciones del servicio o fallas en el sistema.</p>

        <h4>9. Propiedad Intelectual</h4>
        <p>Todo el contenido del Sitio, incluyendo pero no limitado a textos, imágenes, logotipos, gráficos y marcas comerciales, son propiedad exclusiva de Ecoffe o de sus licenciantes. Queda prohibido el uso no autorizado de dicho contenido.</p>

        <h4>10. Protección de Datos Personales</h4>
        <p>La privacidad de nuestros usuarios es muy importante para nosotros. Tratamos los datos personales de acuerdo con nuestra Política de Privacidad. Al utilizar el Sitio, el usuario acepta la recopilación y el uso de sus datos personales conforme a dicha política.</p>

        <h4>11. Modificación de los Términos</h4>
        <p>Ecoffe se reserva el derecho de modificar, actualizar o revisar estos Términos y Condiciones en cualquier momento. Cualquier cambio se publicará en esta página, y los cambios serán efectivos desde su publicación.</p>

        <h4>12. Ley Aplicable</h4>
        <p>Estos Términos y Condiciones se regirán e interpretarán de acuerdo con las leyes del país o región en la que se encuentre Ecoffe. Cualquier disputa relacionada con estos Términos será resuelta en los tribunales de la jurisdicción correspondiente.</p>

        <h4>13. Contacto</h4>
        <p>Si tienes alguna pregunta o inquietud sobre estos Términos y Condiciones, puedes ponerte en contacto con nosotros a través de nuestro correo electrónico: <strong>contacto@ecoffe.com</strong>.</p>
      
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
      </div>

  
        <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="privacyModalLabel">Política de Privacidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                
              <h3>Última actualización: abril de 2025</h3>
        
        <p>En Ecoffe, nos tomamos muy en serio la protección de tu privacidad. Esta Política de Privacidad explica cómo recopilamos, usamos y protegemos tu información personal cuando utilizas nuestro sitio web y servicios.</p>

        <h4>1. Información que Recopilamos</h4>
        <p>Recopilamos información personal cuando realizas un pedido, te registras en nuestro sitio, o cuando te comunicas con nosotros a través de formularios de contacto. Esto incluye tu nombre, dirección de correo electrónico, dirección de envío y datos de pago.</p>

        <h4>2. Uso de la Información</h4>
        <p>La información que recopilamos se utiliza para procesar tus pedidos, mejorar nuestra tienda en línea, ofrecerte atención al cliente y enviarte promociones y novedades relacionadas con nuestros productos. Nunca venderemos tu información personal a terceros.</p>

        <h4>3. Seguridad de los Datos</h4>
        <p>Implementamos medidas de seguridad para proteger tu información personal, como el uso de tecnologías de cifrado y sistemas de pago seguros. Sin embargo, no podemos garantizar que la transmisión de datos por Internet sea completamente segura.</p>

        <h4>4. Cookies</h4>
        <p>Utilizamos cookies para mejorar la experiencia de navegación en nuestro sitio web. Las cookies nos ayudan a recordar tus preferencias, personalizar tu experiencia y analizar el tráfico del sitio. Puedes configurar tu navegador para que rechace las cookies, aunque algunas características del sitio podrían no funcionar correctamente.</p>

        <h4>5. Acceso y Corrección de Datos</h4>
        <p>Si deseas acceder a la información que tenemos sobre ti, o corregir cualquier dato incorrecto, puedes hacerlo a través de tu cuenta en nuestro sitio o poniéndote en contacto con nosotros directamente.</p>

        <h4>6. Compartir Información</h4>
        <p>No compartimos tu información personal con terceros, excepto cuando es necesario para completar tu compra (por ejemplo, con las empresas de envío) o cuando la ley lo requiere.</p>

        <h4>7. Enlaces a Otros Sitios</h4>
        <p>Este sitio puede contener enlaces a otros sitios web que no están bajo el control de Ecoffe. No somos responsables de las políticas de privacidad de esos sitios.</p>

        <h4>8. Modificaciones a la Política de Privacidad</h4>
        <p>Ecoffe se reserva el derecho de modificar esta Política de Privacidad en cualquier momento. Cualquier cambio será publicado en esta página, y se aplicará a partir de la fecha de publicación.</p>

               
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
</div>


      <button type="submit" class="form-btn">Registrarse</button>
      <p class="form-text ">¿Tienes cuenta? <a href="./iniciarsesion.php" class="form-text--link">Iniciar sesión</a></p>
    </form>
</main>
  <?php include '../includes/footer.php';?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
