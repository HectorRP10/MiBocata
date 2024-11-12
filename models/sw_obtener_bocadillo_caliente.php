<?php
session_start();
require_once '../inc/conexionSingleton.php';
require 'BocadilloModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $bocadillo = new Bocadillo();
    $respuesta = $bocadillo->obtener_bocadillo_caliente();

    if ($respuesta) {
        echo json_encode([
            "success" => true,
            "msg" => "Bocadillo caliente exitoso.", 
            "data" => $respuesta
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "msg" => "Ha ocurrido un error.",
            "data" => []
        ]);
    }
}
?>