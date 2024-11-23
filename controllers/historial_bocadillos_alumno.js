function obtener_historial_pedidos_alumno(){
    var dias = document.getElementById('num_registros').value;
    fetch('models/sw_historial_pedidos_alumno.php',
         { 
            method: 'POST',
            headers: {
                 'Content-Type': 'application/x-www-form-urlencoded' 
                },
            body: `dias=${dias}`
         }).
    then(response => response.json()).
    catch((error) => console.error("Error:", error)).
    then(data =>{
        if (data) { 
            var tabla = document.getElementById('tabla');
            tabla.innerHTML = ''; // Limpia la tabla antes de añadir nuevas filas
                for (var i = 0; i < data.length; i++) {
                    var fila = document.createElement('tr');
                    for (var key in data[i]) { 
                        var celda = document.createElement('td');
                        celda.innerHTML = data[i][key];
                        fila.appendChild(celda); 
                    }
            tabla.appendChild(fila);
            }
        }
    })
}

function filtrarHistorial() {
    var dias = document.getElementById('num_registros').value;

    fetch('models/sw_historial_pedidos_alumno.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `dias=${dias}`
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .catch(error => {
        console.error("Error:", error);
    })
    .then(data => {
        if (data.error) {
            console.error("Error del servidor:", data.error);
            return;
        }

        if (data.length > 0) { 
            var tabla = document.getElementById('tabla');
            tabla.innerHTML = ''; // Limpia la tabla antes de añadir nuevas filas
            data.forEach(item => {
                var fila = document.createElement('tr');
                for (var key in item) { 
                    var celda = document.createElement('td');
                    celda.innerHTML = item[key];
                    fila.appendChild(celda); 
                }
                tabla.appendChild(fila);
            });
        } else {
            console.log("No hay datos para mostrar.");
        }
    });
}
