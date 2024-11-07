<?php
session_start(); // Inicia la sesión

if (isset($_SESSION['id'])) {
    echo json_encode([
        "success" => true,
        "id" => $_SESSION['id'],
        "correo" => $_SESSION['correo'],
        "tipo_usuario" => $_SESSION['tipo_usuario']
    ]);
} else {
    echo json_encode([
        "success" => false,
        "msg" => "No hay sesión iniciada"
    ]);
}
?>
