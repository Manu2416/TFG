function copiarCodigo() {
  const codigo = document.getElementById('codigoInv').innerText;
  navigator.clipboard.writeText(codigo)
    .then(() => alert('Código copiado al portapapeles'))
}

