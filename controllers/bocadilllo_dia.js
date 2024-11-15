function obtener_bocadillo_dia() {
    fetch('models/sw_obtener_alumno.php')
        .then(response => response.json())
        .then(alumno_obtenido => {
                    console.log('ID del alumno obtenido:', alumno_obtenido.data); 

            if (alumno_obtenido.success) {
                var id_alumno = alumno_obtenido.data; 

                
                var formData = new FormData();
                formData.append('id_alumno', id_alumno);

                fetch('models/sw_obtener_bocadillo_dia.php', {
                    method: 'POST',
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); 

                        var bocadillo_dia = document.getElementById('bocadillo_dia');
                        var datos_bocadillo_nombre = document.querySelector('#bocadillo_dia p');

                        if (data.success) {
                            // Si hay reserva
                            if (!datos_bocadillo_nombre) {
                                datos_bocadillo_nombre = document.createElement('p');
                                bocadillo_dia.appendChild(datos_bocadillo_nombre);
                            }
                            datos_bocadillo_nombre.innerHTML = `Tu bocadillo reservado es: ${data.data.nombre}`;
                        } else {
                            // Si no hay reserva
                            if (!datos_bocadillo_nombre) {
                                datos_bocadillo_nombre = document.createElement('p');
                                bocadillo_dia.appendChild(datos_bocadillo_nombre);
                            }
                            datos_bocadillo_nombre.innerHTML = "No tienes un bocadillo reservado para hoy.";
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener el bocadillo del día:', error);
                    });
            } else {
                console.error('Error al obtener el ID del alumno:', alumno_obtenido.msg);
            }
        })
        .catch(error => {
            console.error('Error al obtener el ID del alumno:', error);
        });
}
