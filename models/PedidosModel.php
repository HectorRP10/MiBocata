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
    $this->fecha = new DateTime($fecha);
    $this->retirado = new DateTime($retirado);
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
    return $this->fecha->format('Y-m-d H:i:s'); 
}
public function getRetirado() {
    return $this->retirado->format('Y-m-d H:i:s');
}



public function crear_pedido($id_alumno, $id_bocadillo, $precio, $fecha) {
    $db = Database::getInstance();
    $conn = $db->getConnection();

    $query = "INSERT INTO pedidos (id_alumno, id_bocadillo, precio, fecha) VALUES (:id_alumno, :id_bocadillo, :precio, :fecha)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_alumno', $id_alumno);
    $stmt->bindParam(':id_bocadillo', $id_bocadillo);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':fecha', $fecha);

    if ($stmt->execute()) {
        return [
            'success' => true,
            'msg' => 'Pedido realizado con éxito.',
            'data' => [
                'id_alumno' => $id_alumno,
                'id_bocadillo' => $id_bocadillo,
                'precio' => $precio,
                'fecha' => $fecha
            ]
        ];
    } else {
        return [
            'success' => false,
            'msg' => 'Error al realizar el pedido.',
            'data' => []
        ];
    }
}


public function actualizar_pedido($id_alumno, $id_bocadillo, $precio, $fecha_actual, $fecha_formateada) {
    $db = Database::getInstance();
    $conn = $db->getConnection();

    $query = "UPDATE pedidos SET id_bocadillo = :id_bocadillo, precio = :precio, fecha = :fecha WHERE id_alumno = :id_alumno AND DATE(fecha) = :fecha_formateada";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_bocadillo', $id_bocadillo);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':fecha', $fecha_actual);
    $stmt->bindParam(':id_alumno', $id_alumno);
    $stmt->bindParam(':fecha_formateada', $fecha_formateada);

    if ($stmt->execute()) {
        return [
            'success' => true,
            'msg' => 'Pedido actualizado con éxito.',
            'data' => [
                'id_alumno' => $id_alumno,
                'id_bocadillo' => $id_bocadillo,
                'precio' => $precio,
                'fecha' => $fecha_actual
            ]
        ];
    } else {
        return [
            'success' => false,
            'msg' => 'Error al actualizar el pedido.',
            'data' => []
        ];
    }
}

public function eliminar_pedido($id_alumno, $fecha_formateada, $id_bocadillo) {
    $db = Database::getInstance();
    $conn = $db->getConnection();

    $query = "DELETE FROM pedidos WHERE id_alumno = :id_alumno AND DATE(fecha) = :fecha";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_alumno', $id_alumno);
    $stmt->bindParam(':fecha', $fecha_formateada);

    if ($stmt->execute()) {
        return [
            'success' => true,
            'msg' => 'Pedido cancelado con éxito.',
            'data' => [
                'id_alumno' => $id_alumno,
                'id_bocadillo' => $id_bocadillo
            ]
        ];
    } else {
        return [
            'success' => false,
            'msg' => 'Error al eliminar el pedido.',
            'data' => []
        ];
    }
}



public function bocadillo_dia($id_alumno, $fecha) {
    $db = Database::getInstance();
    $conn = $db->getConnection();

    $query = "SELECT b.nombre FROM pedidos p INNER JOIN bocadillos b ON p.id_bocadillo = b.id WHERE p.id_alumno = :id_alumno AND DATE(p.fecha) = :fecha AND (b.fecha_baja IS NULL OR b.fecha_baja > :fecha) LIMIT 1";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_alumno', $id_alumno, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);

    if ($stmt->execute() && $result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return [
            "success" => true,
            "msg" => "Bocadillo del día obtenido con éxito.",
            "data" => $result
        ];
    }
    return [
        "success" => false,
        "msg" => "No tienes un bocadillo reservado para hoy.",
        "data" => []
    ];
}

public function gestionar_pedido($id_alumno, $id_bocadillo, $precio, $fecha) {
    $db = Database::getInstance();
    $conn = $db->getConnection();


    $date = new DateTime($fecha);
    $fecha_formateada = $date->format('Y-m-d');
    $fecha_actual = (new DateTime())->format('Y-m-d H:i:s');


    //Se verifica si hay pedido ya
    $query = "SELECT * FROM pedidos WHERE id_alumno = :id_alumno AND DATE(fecha) = :fecha LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_alumno', $id_alumno);
    $stmt->bindParam(':fecha', $fecha_formateada);
    $stmt->execute();

    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pedido) {
        // Si el id_bocadillo es el mismo, se elimina pedido
        if ($pedido['id_bocadillo'] == $id_bocadillo) {
            return $this->eliminar_pedido($id_alumno, $fecha_formateada, $id_bocadillo);
        } else {
            // Si es un bocadillo diferente, se actualiza pedido
            return $this->actualizar_pedido($id_alumno, $id_bocadillo, $precio, $fecha_actual, $fecha_formateada);
        }
    } else {
        // Si no existe un pedido, se crea
        return $this->crear_pedido($id_alumno, $id_bocadillo, $precio, $fecha);
    }
}


public function total_bocadillos_dia() {
    $db = Database::getInstance();
    $conn = $db->getConnection();

    $fecha_actual = (new DateTime())->format('Y-m-d');
    $query = "SELECT (SELECT COUNT(*) FROM pedidos p JOIN bocadillos b ON p.id_bocadillo = b.id WHERE b.tipo = 'caliente' AND DATE(p.fecha) = :fecha) AS total_calientes, 
    (SELECT COUNT(*) FROM pedidos p JOIN bocadillos b ON p.id_bocadillo = b.id WHERE b.tipo = 'frio' AND DATE(p.fecha) = :fecha) AS total_frios";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':fecha', $fecha_actual);

    if ($stmt->execute() && $result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return [
            "success" => true,
            "msg" => "Bocadillos obtenidos con éxito.",
            "data" => $result
        ];
    }
    return [
        "success" => false,
        "msg" => "No hay bocadillos hoy.",
        "data" => []
    ];
}


public function retirar_pedido($idPedido) {
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $fecha_actual = (new DateTime())->format('Y-m-d H:i:s'); 

        $query = "UPDATE pedidos SET retirado = :fecha WHERE id = :idPedido";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':fecha', $fecha_actual);
        $stmt->bindParam(':idPedido', $idPedido);

        if ($stmt->execute()) {
            return [
                "success" => true,
                "msg" => "Pedido marcado como retirado con éxito.",
            ];
        }

        return [
            "success" => false,
            "msg" => "No se pudo marcar el pedido como retirado."
        ];

    } catch (PDOException $e) {
        return [
            "success" => false,
            "msg" => "Error en la base de datos: " . $e->getMessage()
        ];
    }
}



public function bocadillos_sin_recoger(){
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $fecha_actual = (new DateTime())->format('Y-m-d');

        $query = "SELECT (SELECT COUNT(*) FROM pedidos p JOIN bocadillos b ON p.id_bocadillo = b.id WHERE b.tipo = 'caliente' AND DATE(p.fecha) = :fecha AND p.retirado IS NULL) AS total_calientes, 
                (SELECT COUNT(*) FROM pedidos p JOIN bocadillos b ON p.id_bocadillo = b.id WHERE b.tipo = 'frio' AND DATE(p.fecha) = :fecha AND p.retirado IS NULL) AS total_frios";
                
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':fecha', $fecha_actual);

        if ($stmt->execute() && $result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return [
                "success" => true,
                "msg" => "Bocadillos sin recoger obtenidos con éxito.",
                "data" => $result
            ];
        }
        return [
            "success" => false,
            "msg" => "No hay bocadillos sin recoger hoy.",
            "data" => []
        ];
    }

}
?>