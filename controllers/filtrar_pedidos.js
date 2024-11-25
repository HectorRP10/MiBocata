let pagina_actual = 1;
const cantidad_resultados = 10;

document.addEventListener('DOMContentLoaded', () => {
    cargarPedidos();
});

function cargarPedidos(pagina = 1) {
    pagina_actual = pagina;
    const nombre = document.getElementById('nombre_alumno').value || null;
    const curso = document.getElementById('curso_alumno').value || null;
    const tipo = document.getElementById('tipo_bocadillo').value || null;

    fetch('models/sw_filtrar_pedidos.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ nombre, curso, tipo, pagina: pagina_actual, cantidad_resultados })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const tbody = document.querySelector('table tbody');
            tbody.innerHTML = ''; // Limpiar tabla

            data.pedidos.forEach(pedido => {
                const row = 
                    `<tr>
                        <td>${pedido.alumno}</td>
                        <td>${pedido.bocadillo}</td>
                        <td>${pedido.curso}</td>
                        <td>${pedido.retirado ? pedido.retirado : `<button onclick="retirar_pedidos(${pedido.id})">Retirar</button>`}</td>
                    </tr>`;
                tbody.innerHTML += row;
            });
            actualizar_paginador(data.total, data.pagina, data.cantidad_resultados);
        } else {
            alert('No se encontraron pedidos.');
        }
    })
    .catch(error => console.error('Error:', error));
}

function filtrar_bocadillos(pagina = 1) {
    cargarPedidos(pagina);
}

function actualizar_paginador(total, pagina, cantidad_resultados) {
    const total_paginas = Math.ceil(total / cantidad_resultados);
    const paginador = document.getElementById('paginacion');
    paginador.innerHTML = '';
    
    if (pagina > 1) {
        const prevButton = document.createElement('button'); 
        prevButton.textContent = 'Anterior'; 
        prevButton.addEventListener('click', () => cargarPedidos(pagina - 1)); 
        paginador.appendChild(prevButton); 
    }

    const pagina_actual = document.createElement('span');
    pagina_actual.textContent = ` Página ${pagina} de ${total_paginas} `; 
    paginador.appendChild(pagina_actual);
    
    if (pagina < total_paginas) { 
        const nextButton = document.createElement('button'); 
        nextButton.textContent = 'Siguiente'; 
        nextButton.addEventListener('click', () => cargarPedidos(pagina + 1)); 
        paginador.appendChild(nextButton);
    }
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
            cargarPedidos(pagina_actual); // para recargar dinámicamente 
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
