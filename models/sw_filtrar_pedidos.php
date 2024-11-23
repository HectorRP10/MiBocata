<?php
require_once '../inc/conexionSingleton.php';

try {
    $conexion = Database::getInstance()->getConnection();

    $input = json_decode(file_get_contents("php://input"), true);
    $nombre = isset($input['nombre']) ? '%' . $input['nombre'] . '%' : null;
    $curso = isset($input['curso']) ? '%' . $input['curso'] . '%' : null;
    $tipo = isset($input['tipo']) ? $input['tipo'] : null;

   
    $sql="SELECT p.id, a.nombre_completo AS alumno, c.nombre AS curso, b.tipo AS bocadillo, p.retirado FROM pedidos p JOIN alumnos a ON p.id_alumno = a.id JOIN bocadillos b ON p.id_bocadillo = b.id LEFT JOIN cursos c ON a.id_cursos = c.id 
    WHERE DATE(p.fecha) = CURDATE() AND (:nombre IS NULL OR a.nombre_completo LIKE :nombre) AND (:curso IS NULL OR c.nombre LIKE :curso) AND (:tipo IS NULL OR b.tipo = :tipo)";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':curso', $curso);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->execute();

    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'pedidos' => $pedidos]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>