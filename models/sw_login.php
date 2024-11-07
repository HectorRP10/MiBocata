
<?php
session_start();
require_once '../inc/conexionSingleton.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contrasenya = $_POST['contrasenya'];

    $db = Database::getInstance();
    $pdo = $db->getConnection();

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = :correo AND contrasenya = :contrasenya LIMIT 1");
    $stmt->execute(['correo' => $correo, 'contrasenya' => $contrasenya]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['correo'] = $user['correo'];
        echo json_encode([
            "success" => true,
            "msg" => "Login exitoso.", 
            "data" => [ 
                [
                    "id" => $user['id'],
                    "mac" => $user['mac'],
                    "correo" => $user['correo'],
                    "tipo" => $user['tipo'] 
                ]
            ]
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "msg" => "Credenciales incorrectas.",
            "data" => []
        ]);
    }
}
?>
