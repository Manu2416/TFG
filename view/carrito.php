<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   <!-- Estilos propios -->
    <link href="../styles/footer.css" rel="stylesheet">
    <link href="../styles/navbar.css" rel="stylesheet">
    <link href="../styles/body.css" rel="stylesheet">
   
    <!-- Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <title>Carrito de Compras</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <?php include '../includes/cabecera.php'; ?>
        <main class="container py-5">
            <h2 class="mb-4 text-center text">Tu carrito</h2>

            <div id="carrito-contenido" class="row g-4">
            <!-- Aquí se inyectarán los productos -->
            </div>

            <div class="text-end mt-5">
            <h4>Total: <span id="carrito-total">0.00 €</span></h4>
            <button class="btn btn-success mt-3">Finalizar compra</button>
            </div>
        </main>

  <script>
    // Ejemplo de productos simulados (normalmente esto vendría del localStorage o backend)
    const productosEnCarrito = [
      {
        id: 1,
        nombre: "Café Espresso",
        precio: 4.50,
        cantidad: 2,
        imagen: "https://via.placeholder.com/100"
      },
      {
        id: 2,
        nombre: "Cápsulas Intensas",
        precio: 6.75,
        cantidad: 1,
        imagen: "https://via.placeholder.com/100"
      }
    ];

    const contenedor = document.getElementById('carrito-contenido');
    const total = document.getElementById('carrito-total');

    function renderCarrito() {
      contenedor.innerHTML = '';
      let totalGeneral = 0;

      productosEnCarrito.forEach((producto, index) => {
        const subtotal = producto.precio * producto.cantidad;
        totalGeneral += subtotal;

        contenedor.innerHTML += `
          <div class="col-md-6">
            <div class="card shadow-sm">
              <div class="row g-0 align-items-center">
                <div class="col-4">
                  <img src="${producto.imagen}" class="img-fluid rounded-start" alt="${producto.nombre}">
                </div>
                <div class="col-8">
                  <div class="card-body">
                    <h5 class="card-title">${producto.nombre}</h5>
                    <p class="card-text">Precio: ${producto.precio.toFixed(2)} €</p>
                    <div class="input-group mb-2">
                      <label class="input-group-text">Cantidad</label>
                      <input type="number" min="1" value="${producto.cantidad}" class="form-control" onchange="cambiarCantidad(${index}, this.value)">
                    </div>
                    <p class="card-text"><strong>Subtotal:</strong> ${subtotal.toFixed(2)} €</p>
                    <button class="btn btn-danger btn-sm" onclick="eliminarProducto(${index})">Eliminar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        `;
      });

      total.textContent = totalGeneral.toFixed(2) + ' €';
    }

    function cambiarCantidad(index, nuevaCantidad) {
      productosEnCarrito[index].cantidad = parseInt(nuevaCantidad);
      renderCarrito();
    }

    function eliminarProducto(index) {
      productosEnCarrito.splice(index, 1);
      renderCarrito();
    }

    // Inicializa
    renderCarrito();
  </script>
  
    <?php include '../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
