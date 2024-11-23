<?php
session_start();
require_once '../inc/conexionSingleton.php';

$filtro_dias = isset($_POST['dias']) ? intval($_POST['dias']) : 7;

$columns=['bocadillos.nombre AS bocadillo','bocadillos.tipo AS tipo','pedidos.precio AS precio','pedidos.fecha AS fecha'];

$conexion = Database::getInstance()->getConnection();
$sql="SELECT ". implode( ", ", $columns).
        " from bocadillos, pedidos 
        where pedidos.id_bocadillo=bocadillos.id and pedidos.id_alumno=:alumno and pedidos.fecha >= CURDATE() - INTERVAL :dias DAY
        order by pedidos.fecha";


$stmt=$conexion->prepare($sql);
$stmt->bindParam(':alumno', $_SESSION['id'], PDO::PARAM_INT);
$stmt->bindParam(':dias', $filtro_dias, PDO::PARAM_INT);
$stmt->execute(); 
$datos = [];
  
    if ($stmt->rowCount() > 0) {
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
echo json_encode($datos);
?>