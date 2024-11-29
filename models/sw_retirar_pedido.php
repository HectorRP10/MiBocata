<?php
session_start();
require_once '../inc/conexionSingleton.php';
require 'PedidosModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Para decodificar el json que recibo
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['idPedido'])) {
        echo json_encode([
            "success" => false,
            "msg" => "Error."
        ]);
        exit;
    }

    $idPedido = $input['idPedido'];

    $pedido = new Pedido();
    $resultado = $pedido->retirar_pedido($idPedido);

    echo json_encode($resultado);
}
?>
