document.addEventListener('DOMContentLoaded', () => {
    // para mostrar los pedidos cuando carga la pagina
    cargarPedidos();
});

function cargarPedidos() {
    fetch('models/sw_filtrar_pedidos.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ nombre: null, curso: null, tipo: null })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            var tbody = document.querySelector('table tbody');
            tbody.innerHTML = ''; // Limpiar tabla

            data.pedidos.forEach(pedido => {
                var row = 
                    `<tr>
                        <td>${pedido.alumno}</td>
                        <td>${pedido.bocadillo}</td>
                        <td>${pedido.curso}</td>
                        <td>
                            ${//si esta retirado muestra fecha sino boton
                                pedido.retirado ? pedido.retirado : `<button onclick="retirar_pedidos(${pedido.id})">Retirar</button>` 
                            }
                        </td>
                    </tr>`;
                tbody.innerHTML += row;
            });
        } else {
            alert('No se encontraron pedidos.');
        }
    })
    .catch(error => console.error('Error:', error));
}

function filtrar_bocadillos() {
    var nombre = document.getElementById('nombre_alumno').value || null;
    var curso = document.getElementById('curso_alumno').value || null;
    var tipo = document.getElementById('tipo_bocadillo').value || null;

    fetch('models/sw_filtrar_pedidos.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ nombre, curso, tipo })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            var tbody = document.querySelector('table tbody');
            tbody.innerHTML = ''; 

            data.pedidos.forEach(pedido => {
                var row = 
                    `<tr>
                        <td>${pedido.alumno}</td>
                        <td>${pedido.bocadillo}</td>
                        <td>${pedido.curso}</td>
                        <td>
                            ${//si esta retirado muestra fecha sino boton
                                pedido.retirado ? pedido.retirado : `<button onclick="retirar_pedidos(${pedido.id})">Retirar</button>`
                            }
                        </td>
                    </tr>`;
                tbody.innerHTML += row;
            });
        } else {
            alert('No se encontraron pedidos.');
        }
    })
    .catch(error => console.error('Error:', error));
}

function retirar_pedidos(idPedido) {

    fetch('models/sw_retirar_pedido.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idPedido })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Pedido marcado como retirado con éxito:', data);

            alert('El pedido ha sido marcado como retirado.');
            cargarPedidos(); // para recargar dinamicamente 
        } else {
            console.error('Error al marcar el pedido:', data.msg);
            alert(`Error: ${data.msg}`);
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
        alert('Hubo un error con el pedido.');
    });
}
