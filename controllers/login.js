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
                const userType = data.data[0].tipo.toLowerCase();
                 if (userType === 'alumno') { 
                     
                    window.location.href = 'pruebalogin.html';
                 } 
                else if (userType === 'cocina') {
                    
                    window.location.href = 'pruebacocina.html'; 
                }
                    else if (userType === 'admin') {
                     
                    window.location.href = 'pruebaadmin.html'; 
                }
            } else { 
                    alert(data.msg); } 
            }) 
            .catch(error => { console.error('Error:', error);    
            });
}