<?php
session_start();
require_once '../inc/conexionSingleton.php';
require 'PedidosModel.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_alumno = isset($_POST['id_alumno']) ? $_POST['id_alumno'] : null;

    if ($id_alumno) {
        $pedido = new Pedido();
        $fecha = date('Y-m-d'); 
        $respuesta = $pedido->bocadillo_dia($id_alumno, $fecha);
        echo json_encode($respuesta);

    } else {
        echo json_encode([
            "success" => false,
            "msg" => "El alumno no está logueado.",
            "data" => []
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "msg" => "Método no permitido.",
        "data" => []
    ]);
}
