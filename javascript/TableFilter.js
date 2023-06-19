
document.getElementById('filtroTabla').addEventListener('input', function () {
    var filtro = this.value.toLowerCase();
    var filas = document.querySelectorAll('#dataTable tbody tr');

    filas.forEach(function (fila) {
        var columnaNombre = fila.querySelector('td:nth-child(5)');
        var textoNombre = columnaNombre.textContent.toLowerCase();

        if (textoNombre.includes(filtro)) {
            fila.style.display = 'table-row';
        } else {
            fila.style.display = 'none';
        }
    });
});

