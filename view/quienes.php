<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Estilos propios -->
    <link href="../styles/footer.css" rel="stylesheet">
    <link href="../styles/navbar.css" rel="stylesheet">
    <link href="../styles/body.css" rel="stylesheet">
    <link href="../styles/quienes.css" rel="stylesheet">
    
 
    <!-- Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include '../includes/cabecera.php'; ?>

<main class="container-fluid mb-5">
    <div class="row">
      <div class="col consulta-title-container pt-5">
        <h2 class="consulta-title">QUIÉNES SOMOS</h2>
      </div>
    </div>
    <div class="row consulta-info-container">
      <div class="col-10 consulta-info">
        <ul class="nav nav-pills mb-3 consulta-info-nav" id="pills-tab" role="tablist">
          <li class="nav-item consulta-info-nav-item" role="presentation">
            <button class="info-link active consulta-info-nav-item-button" id="historia" data-bs-toggle="pill" data-bs-target="#pills-historia" type="button" role="tab" aria-controls="pills-historia" aria-selected="true">ORÍGENES</button>
          </li>
          <li class="nav-item consulta-info-nav-item" role="presentation">
            <button class="info-link consulta-info-nav-item-button" id="filosofia" data-bs-toggle="pill" data-bs-target="#pills-filosofia" type="button" role="tab" aria-controls="pills-filosofia" aria-selected="false">CÓMO TRABAJAMOS</button>
          </li>
          <li class="nav-item consulta-info-nav-item" role="presentation">
            <button class="info-link consulta-info-nav-item-button" id="sostenibilidad" data-bs-toggle="pill" data-bs-target="#pills-sostenibilidad" type="button" role="tab" aria-controls="pills-sostenibilidad" aria-selected="false">IMPACTO POSITIVO</button>
          </li>
        </ul>
        <div class="tab-content consulta-info-tab" id="pills-tabContent">

         
          <div class="tab-pane fade show active" id="pills-historia" role="tabpanel" aria-labelledby="historia">
            <div class="tab-elements">
              <h3 class="tab-elements-title">UNA IDEA NACIDA DEL CAFÉ</h3>
              <p class="tab-elements-text">
                Todo empezó con una pregunta: ¿y si el café pudiera ser algo más que una bebida? En Ecoffe quisimos darle sentido a cada taza. Nos inspiramos en el Amazonas, en su gente y en su energía, para crear un producto que conecta calidad, origen y propósito.
              </p>
            </div>
          </div>

     
          <div class="tab-pane fade" id="pills-filosofia" role="tabpanel" aria-labelledby="filosofia">
            <div class="tab-elements">
              <h3 class="tab-elements-title">CERCANÍA, CALIDAD Y TRANSPARENCIA</h3>
              <p class="tab-elements-text">
                No trabajamos con intermediarios, trabajamos con personas. Nos relacionamos directamente con agricultores locales, seleccionamos el mejor grano y apostamos por procesos responsables. Nuestro café es el resultado de un trabajo honesto y bien hecho.
              </p>
            </div>
          </div>

    
          <div class="tab-pane fade" id="pills-sostenibilidad" role="tabpanel" aria-labelledby="sostenibilidad">
            <div class="tab-elements">
              <h3 class="tab-elements-title">CAFÉ QUE HACE BIEN</h3>
              <p class="tab-elements-text">
                Elegimos cápsulas biodegradables, reducimos residuos y apoyamos proyectos locales en zonas cafetaleras. Nuestra misión es simple: que tomar café también signifique cuidar el planeta y a quienes lo hacen posible.
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>
   
</main>


<?php include '../includes/footer.php';?>
<script src="../scripts/quienes.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>