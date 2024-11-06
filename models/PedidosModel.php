<?php
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


public function nuevo_pedido(){
    $conexion = Database::getInstance()->getConnection();

    $sql="INSERT INTO pedidos (id_alumno, id_bocadillo, id_descuento, precio, fecha, retirado) VALUES (:id_alumno, :id_bocadillo, :id_descuento, :precio, :fecha, :retirado)";
    $stmt = $conexion->prepare($sql);

    //se convierte para poder insertarse en la BD
    $fecha_convertida = $this->fecha->format('Y-m-d H:i:s');

    $stmt->execute([
        ':id_alumno' => $this->id_alumno,
        ':id_bocadillo' => $this->id_bocadillo,
        ':id_descuento' => $this->id_descuento,
        ':precio' => $this->precio,
        ':fecha' => $fecha_convertida,
        ':retirado' => $this->retirado
    ]);

    //Se asigna el ID del pedido, es autoincrement en la BD
    if ($stmt->rowCount() > 0) {
        $this->id = $conexion->lastInsertId(); 
        return $this;
    } else {
        return null;
    }


}




}
?>