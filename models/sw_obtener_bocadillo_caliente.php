<?php
session_start();
require_once '../inc/conexionSingleton.php';
require 'BocadilloModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $bocadillo = Bocadillo::obtener_bocadillo_caliente();

    if ($bocadillo) {
        echo json_encode([
            "success" => true,
            "msg" => "Bocadillo caliente exitoso.", 
            "data" => $bocadillo
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