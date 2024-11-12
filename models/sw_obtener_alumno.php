<?php
session_start();
require_once '../inc/conexionSingleton.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $alumno = $_SESSION['id'];

    if ($alumno) {
        echo json_encode([
            "success" => true,
            "msg" => "Alumno obtenido exitoso.", 
            "data" => $alumno
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "msg" => "Ha ocurrido un error al encontrar el alumno.",
            "data" => []
        ]);
    }
}
?>