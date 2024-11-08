
function obtener_bocadillo_caliente(){
    fetch('models/sw_obtener_bocadillo_caliente.php').
    then(response => response.json()).
    then(data => {  
        if(data.success){
            var bocadillo_caliente = document.getElementById('bocadillo_caliente');
            var datos_bocadillo_nombre = document.createElement('p');
            var datos_bocadillo_precio = document.createElement('p');
            var datos_bocadillo_ingredientes = document.createElement('p');
            datos_bocadillo_nombre.innerHTML = data.data[0].nombre;
            datos_bocadillo_precio.innerHTML = data.data[0].precio;
            datos_bocadillo_ingredientes.innerHTML = data.data[0].ingredientes;
            bocadillo_caliente.appendChild(datos_bocadillo_nombre);
            bocadillo_caliente.appendChild(datos_bocadillo_precio);
            bocadillo_caliente.appendChild(datos_bocadillo_ingredientes);
        } else {
            console.log(data.msg);
            
        }
    }

    );
}