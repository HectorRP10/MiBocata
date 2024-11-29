<?php
require_once '../inc/conexionSingleton.php';
require 'PedidosModel.php';

header('Content-Type: application/json');

$pedido = new Pedido();
$response = $pedido->bocadillos_sin_recoger();
echo json_encode($response);
?>
