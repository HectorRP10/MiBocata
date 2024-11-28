<?php
require_once '../inc/conexionSingleton.php';

try {
    $conexion = Database::getInstance()->getConnection();
    $input = json_decode(file_get_contents("php://input"), true);
    $alumno_id = $input['id'];
    $accion = $input['accion']; 

    if ($accion == 'baja') {
        $fecha_baja = date('Y-m-d'); 
        $motivo_baja = "Baja realizada el " . $fecha_baja; 

        $sql = "UPDATE alumnos SET fecha_baja = :fecha_baja, motivo_baja = :motivo_baja WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':fecha_baja', $fecha_baja);
        $stmt->bindParam(':motivo_baja', $motivo_baja);
    } else if ($accion == 'alta') {
        
        $sql = "UPDATE alumnos SET fecha_baja = NULL, motivo_baja = NULL WHERE id = :id";
        $stmt = $conexion->prepare($sql);
    }

    $stmt->bindParam(':id', $alumno_id);
    $stmt->execute();

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
