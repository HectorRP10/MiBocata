function total_bocadillos_dia() {
    fetch('models/sw_total_bocadillos_dia.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var contenedorCalientes = document.getElementById('bocadillos_calientes');
                var contenedorFrios = document.getElementById('bocadillos_frios');
                contenedorCalientes.innerHTML = '';
                contenedorFrios.innerHTML = '';
                var totalCalientes = document.createElement('p');
                totalCalientes.innerHTML = `Bocadillos Calientes: ${data.data.total_calientes}`;
                contenedorCalientes.appendChild(totalCalientes);

                var totalFrios = document.createElement('p');
                totalFrios.innerHTML = `Bocadillos Fríos: ${data.data.total_frios}`;
                contenedorFrios.appendChild(totalFrios);
            } else {
                console.error(data.msg);
            }
        })
        .catch(error => console.error('Error en la petición:', error));
}


function bocadillos_por_retirar() {
    fetch('models/sw_total_por_recoger.php')
        .then(response => response.json()) 
        .then(data => {
            if (data.success) {
                var contenedorCalientes = document.getElementById('retirar_bocadillos_calientes');
                var contenedorFrios = document.getElementById('retirar_bocadillos_frios');

                contenedorCalientes.innerHTML = `<p>Sin recoger: ${data.data.total_calientes}</p>`;
                contenedorFrios.innerHTML = `<p>Sin recoger: ${data.data.total_frios}</p>`;
            } else {
                console.error(data.msg);
            }
        })
        .catch(error => console.error('Error en la petición:', error));
}
