<?php
require_once '../inc/conexionSingleton.php';

try {
    $conexion = Database::getInstance()->getConnection();
    $input = json_decode(file_get_contents("php://input"), true);
    $nombre = isset($input['nombre']) ? '%' . $input['nombre'] . '%' : null;
    $curso = isset($input['curso']) ? '%' . $input['curso'] . '%' : null;

    $sql = "SELECT a.id, a.nombre_completo AS alumno, c.nombre AS curso, a.motivo_baja AS motivo FROM alumnos a LEFT JOIN cursos c ON a.id_cursos = c.id
    WHERE (:nombre IS NULL OR a.nombre_completo LIKE :nombre) AND (:curso IS NULL OR c.nombre LIKE :curso)";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':curso', $curso);
    $stmt->execute();

    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'alumnos' => $alumnos]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>

