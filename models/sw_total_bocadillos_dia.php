<?php
session_start();
require_once '../inc/conexionSingleton.php';
require 'PedidosModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $pedido = new Pedido();
    $respuesta = $pedido->total_bocadillos_dia();

    echo json_encode($respuesta);
}
?>
