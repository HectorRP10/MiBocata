
function comprueba_sesion(){
    fetch('models/session_info.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            var usuario = document.getElementById('usuario');
            var usuario_correo=document.createElement('p');
            usuario_correo.innerHTML = data.correo;
            usuario.appendChild(usuario_correo);
            // Continúa con las operaciones si la sesión está activa
        } else {
            console.log(data.msg);
            // Redirige al login si no hay sesión
            window.location.href = 'login.html';
        }
    });
}


