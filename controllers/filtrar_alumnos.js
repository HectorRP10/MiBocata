document.addEventListener('DOMContentLoaded', () => {
    MostrarAlumnos();
});

function MostrarAlumnos() {
    fetch('models/sw_filtrar_alumnos.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({}) 
    })
    .then(response => response.json())
    .then(data => {
        console.log('Datos recibidos:', data); 

        var tbody = document.querySelector('table tbody');
        tbody.innerHTML = ''; 

        if (data.success && data.alumnos.length > 0) {
            data.alumnos.forEach(alumno => {
                var row = `
                    <tr>
                        <td>${alumno.alumno}</td>
                        <td>${alumno.curso}</td>
                        <td>${alumno.motivo}</td>
                        <td>
                            <button onclick="dar_alta(${alumno.id})">Alta</button>
                            <button onclick="dar_baja(${alumno.id})">Baja</button>
                        </td>
                        <td>
                            <button onclick="reservar_bocadillo_frio()">Reservar Frío</button>
                            <button onclick="reservar_bocadillo()">Reservar Caliente</button>
                        </td>
                    </tr>`;
                tbody.innerHTML += row;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="5">No se encontraron alumnos.</td></tr>';
        }
    })
    .catch(error => console.error('Error en la solicitud:', error));
}




function filtrar_alumnos() {
    var nombre = document.getElementById('nombre_alumno').value || null;
    var curso = document.getElementById('curso_alumno').value || null;

    fetch('models/sw_filtrar_alumnos.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ nombre, curso })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            var tbody = document.querySelector('table tbody');
            tbody.innerHTML = ''; 

            data.alumnos.forEach(alumno => {
                var row = 
                    `<tr>
                        <td>${alumno.alumno}</td>
                        <td>${alumno.curso}</td>
                        <td>${alumno.motivo}</td>
                        <td>
                            <button onclick="dar_alta(${alumno.id})">Alta</button>
                            <button onclick="dar_baja(${alumno.id})">Baja</button>
                        </td>
                        <td>
                            <button onclick="reservar_bocadillo_frio()">Reservar Frío</button>
                            <button onclick="reservar_bocadillo()">Reservar Caliente</button>
                        </td>
                    </tr>`;
                tbody.innerHTML += row;
            });
        } else {
            alert('No se encontraron alumnos.');
        }
    })
    .catch(error => console.error('Error:', error));
}





function dar_baja(id) {
    fetch('models/sw_gestionar_baja_alta.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: id,
            accion: 'baja'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Alumno dado de baja correctamente.");
           
            MostrarAlumnos();
        } else {
            alert("Error al dar de baja al alumno.");
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
    });
}

function dar_alta(id) {
    fetch('models/sw_gestionar_baja_alta.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: id,
            accion: 'alta' 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Alumno dado de alta correctamente.");
            MostrarAlumnos();
        } else {
            alert("Error al dar de alta al alumno.");
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
    });
}