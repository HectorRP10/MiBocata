function reservar_bocadillo_frio() {
    // obtengo el bocadillo caliente para poder reservarlo
    fetch('models/sw_obtener_bocadillo_frio.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Se obtienen los datos del bocadillo
            const bocadillo = data.data[0];
            const id_bocadillo = bocadillo.id; 
            const precio = bocadillo.precio; 
            fetch('models/sw_obtener_alumno.php').
            then(response => response.json()).
            then(alumno_obtenido =>{
                if (alumno_obtenido.success){
                    const id_alumno = alumno_obtenido.data;
                    const formData = new FormData();
            formData.append('id_alumno', id_alumno);
            formData.append('id_bocadillo', id_bocadillo);
            formData.append('precio', precio);

            // Una vez obtenido el bocadillo lo reservo
            fetch('models/sw_reserva_bocadillo.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Pedido realizado con éxito:', data);

                    // Actualiza el div de bocadillo
                    obtener_bocadillo_dia();
                } else {
                    console.log('Error al realizar el pedido:', data.msg);
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
            });
                }
                else{
                    console.log('Error al obtener el alumno:', alumno_obtenido.msg);
                }
            })
        } else {
            console.log('Error al obtener el bocadillo frio:', data.msg);
        }
    })
    .catch(error => {
        console.error('Error al obtener el bocadillo:', error);
    });
}
