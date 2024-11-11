function reservar_bocadillo() {
    // obtengo el bocadillo caliente para poder reservarlo
    fetch('models/sw_obtener_bocadillo_caliente.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Se obtienen los datos del bocadillo
            const bocadillo = data.data[0];
            const id_bocadillo = bocadillo.id; 
            const precio = bocadillo.precio; 
            const id_alumno = 1;                      //TODO MODIFICAR EL USUARIO SEGUN LOGIN

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
                } else {
                    console.log('Error al realizar el pedido:', data.msg);
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
            });
        } else {
            console.log('Error al obtener el bocadillo caliente:', data.msg);
        }
    })
    .catch(error => {
        console.error('Error al obtener el bocadillo:', error);
    });
}
