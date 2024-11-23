function login(){
    const correo = document.getElementById('mail').value; 
    const contrasenya = document.getElementById('pass').value;

    fetch('models/sw_login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `correo=${correo}&contrasenya=${contrasenya}` 
        }).then(response => response.json())
            .then(data => {
            if (data.success) { 
                const tipo_usuario = data.data[0].tipo.toLowerCase();
                 if (tipo_usuario === 'alumno') { 
                     
                    window.location.href = 'dashboard_alumno.html';
                 } 
                else if (tipo_usuario === 'cocina') {
                    
                    window.location.href = 'DashboardCocina.html'; 
                }
                    else if (tipo_usuario === 'admin') {
                     
                    window.location.href = 'pruebaadmin.html'; 
                }
            } else { 
                    alert(data.msg); } 
            }) 
            .catch(error => { console.error('Error:', error);    
            });
}