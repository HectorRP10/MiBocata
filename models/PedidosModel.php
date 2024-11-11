<?php
require_once '../inc/conexionSingleton.php';
class Pedido{

public $id;
public $id_alumno;
public $id_bocadillo;
public $id_descuento;
public $precio;
public $fecha;
public $retirado;

public function __construct($id=null,$id_alumno=null,$id_bocadillo=null,$id_descuento=null,$precio=null,$fecha=null,$retirado=null){

    $this->id = $id;
    $this->id_alumno = $id_alumno;
    $this->id_bocadillo = $id_bocadillo;
    $this->id_descuento = $id_descuento;
    $this->precio = $precio;
    $this->fecha = new DateTime();
    $this->retirado = null;
}


public function getId() {
    return $this->id;
}
public function getIdAlumno() {
    return $this->id_alumno;
}
public function getIdBocadillo() {
    return $this->id_bocadillo;
}
public function getIdDescuento() {
    return $this->id_descuento;
}
public function getPrecio() {
    return $this->precio;
}
public function getFecha() {
    return $this->fecha;
}
public function getRetirado() {
    return $this->retirado;
}



public static function nuevo_pedido($id_alumno, $id_bocadillo, $precio, $fecha) {
    // Conexión a la base de datos
    $db = Database::getInstance();
    $conn = $db->getConnection();

    
    $query = "INSERT INTO pedidos (id_alumno, id_bocadillo, precio, fecha) VALUES ($id_alumno, $id_bocadillo, '$precio', '$fecha')";
    $stmt = $conn->prepare($query);
    
    if ($stmt->execute()) {
        return [
            'id_alumno' => $id_alumno,
            'id_bocadillo' => $id_bocadillo,
            'precio' => $precio,
            'fecha' => $fecha
        ];
    } else {
        return false;
    }
}

    
}
?>