<?php
session_start();
require_once '../inc/conexionSingleton.php';
require 'PedidosModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_alumno = $_POST['id_alumno'];  
    $id_bocadillo = $_POST['id_bocadillo'];
    $precio = $_POST['precio'];
    $fecha = date('Y-m-d H:i:s');


    $pedido = new Pedido(); 
    $resultado = $pedido->nuevo_pedido($id_alumno, $id_bocadillo, $precio, $fecha);

    if ($resultado) {
        echo json_encode([
            "success" => true,
            "msg" => "Bocadillo reservado con éxito.", 
            "data" => $resultado
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "msg" => "Datos incompletos para realizar el pedido.",
            "data" => []
        ]);
    }
}
?>
