
document.addEventListener('DOMContentLoaded', () => {
if (typeof mensajeErrorCarrito !== 'undefined') {
    document.getElementById('modalErrorTexto').textContent = mensajeErrorCarrito;
    const modalError = new bootstrap.Modal(document.getElementById('modalErrorCarrito'));
    modalError.show();
}

if (typeof mensajeExitoCarrito !== 'undefined') {
    document.getElementById('modalExitoTexto').textContent = mensajeExitoCarrito;
    const modalExito = new bootstrap.Modal(document.getElementById('modalExitoCarrito'));
    modalExito.show();
}
});

