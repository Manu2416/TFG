
  
<header>
  <nav class="navbar navbar-expand-lg ">
  <div class="container-fluid mx-md-5 mx-0">
    
      <a class="navbar-brand" href="../view/inicio.php">
        <img src="../images/ecoffe.png" alt="Logo ecoffe">
      </a>

      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <a class="navbar-brand" href="../view/inicio.php">
            <img src="../images/ecoffe.png" alt="Logo ecoffe">
          </a>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-center ">
            <li class="nav-item">
              <a class="nav-link" href="../view/quienes.php">¿QUIENES SOMOS?</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">CAFES</a>
              <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Bruma del Amazonas</a></li>
              <li><a class="dropdown-item" href="#">Latte Luz de la Tierra</a></li>
              <li><a class="dropdown-item" href="#">Espresso Raíz Profunda</a></li>
              <li><a class="dropdown-item" href="#">Capuccino Cosecha Solar</a></li>

              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../view/accesorios.php">ACCESORIOS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../view/packs.php">PACKS</a>
            </li>
          </ul>
        </div>
      </div>

     
      <ul class="navbar-icons">
        <li><a href="../view/puntos.php " class="navbar-button"><i class="bi bi-gift-fill"></i></a></li>
        <li><a href="../view/carrito.php" class="navbar-button"><i class="bi bi-bag-fill"></i></a></li>
        <?php if (isset($_SESSION['usuario'])): ?>
            <a href="../view/perfil.php" class="navbar-button"><i class="bi bi-person-fill"></i></a>
        <?php else: ?>
            <a href="../view/iniciarsesion.php" class="navbar-button"><i class="bi bi-person-fill"></i></a>
        <?php endif; ?>
      </ul>
     
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
     
    </div>
  </nav>
</header>


