<?php
class Pedidos(){

public $id;
public $id_alumno;
public $id_boacadillo;
public $id_descuento;
public $precio;
public $fecha;
public $retirado;

public function __construct($id=null,$id_alumno=null,$id_boacadillo=null,$id_descuento=null,$precio=null,$fecha=null,$retirado=null){

    $this->id = $id;
    $this->id_alumno = $id_alumno;
    $this->id_bocadillo = $id_boacadillo;
    $this->id_descuento = $id_descuento;
    $this->precio = $precio;
    $this->fecha = $fecha;
    $this->retirado = $retirado;
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


}
?>