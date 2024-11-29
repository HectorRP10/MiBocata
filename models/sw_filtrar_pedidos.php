<?php
require_once '../inc/conexionSingleton.php';

try {
    $conexion = Database::getInstance()->getConnection();

   // Recibir y decodificar JSON del cuerpo de la solicitud
   $input = json_decode(file_get_contents("php://input"), true);
   $nombre = isset($input['nombre']) ? '%' . $input['nombre'] . '%' : null;
   $curso = isset($input['curso']) ? '%' . $input['curso'] . '%' : null;
   $tipo = isset($input['tipo']) && $input['tipo'] !== '' ? $input['tipo'] : null; // Asegurarse de que no sea una cadena vacía
   $pagina = isset($input['pagina']) ? (int)$input['pagina'] : 1;
   $cantidad_resultados = isset($input['cantidad_resultados']) ? (int)$input['cantidad_resultados'] : 10;
   $offset = ($pagina - 1) * $cantidad_resultados;

   // Consulta para contar el número total de registros
   $sql_total = "SELECT COUNT(*) as total 
                 FROM pedidos p 
                 JOIN alumnos a ON p.id_alumno = a.id 
                 JOIN bocadillos b ON p.id_bocadillo = b.id 
                 LEFT JOIN cursos c ON a.id_cursos = c.id 
                 WHERE DATE(p.fecha) = CURDATE()";
   
   // Consulta para obtener resultados paginados
   $sql = "SELECT p.id, a.nombre_completo AS alumno, c.nombre AS curso, b.tipo AS bocadillo, p.retirado 
           FROM pedidos p 
           JOIN alumnos a ON p.id_alumno = a.id 
           JOIN bocadillos b ON p.id_bocadillo = b.id 
           LEFT JOIN cursos c ON a.id_cursos = c.id 
           WHERE DATE(p.fecha) = CURDATE()";
   
   // Añadir condiciones de filtrado
   if ($nombre) {
        $nombre = "%$nombre%";
        $sql .= " AND a.nombre_completo LIKE :nombre";
        $sql_total .= " AND a.nombre_completo LIKE :nombre";
   }
   if ($curso) {
        $curso = "%$curso%";
        $sql .= " AND c.nombre LIKE :curso";
        $sql_total .= " AND c.nombre LIKE :curso";
   }
   if ($tipo) {
        $sql .= " AND b.tipo = :tipo";
        $sql_total .= " AND b.tipo = :tipo";
   }
   
   $sql .= " LIMIT :offset, :cantidad_resultados";

   // Preparar y ejecutar la consulta para contar los registros totales
   $stmt_total = $conexion->prepare($sql_total);
   if ($nombre) $stmt_total->bindParam(':nombre', $nombre);
   if ($curso) $stmt_total->bindParam(':curso', $curso);
   if ($tipo) $stmt_total->bindParam(':tipo', $tipo);
   $stmt_total->execute();
   $total_resultados = $stmt_total->fetch(PDO::FETCH_ASSOC)['total'];

   // Preparar y ejecutar la consulta para obtener resultados paginados
   $stmt = $conexion->prepare($sql);
   if ($nombre) $stmt->bindParam(':nombre', $nombre);
   if ($curso) $stmt->bindParam(':curso', $curso);
   if ($tipo) $stmt->bindParam(':tipo', $tipo);
   $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
   $stmt->bindParam(':cantidad_resultados', $cantidad_resultados, PDO::PARAM_INT);
   $stmt->execute();
   $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

   // Respuesta JSON
   echo json_encode([
       'success' => true,
       'pedidos' => $pedidos,
       'total' => $total_resultados,
       'pagina' => $pagina,
       'cantidad_resultados' => $cantidad_resultados
   ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>