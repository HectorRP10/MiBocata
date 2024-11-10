<?php
// Incluir la clase Database
require_once '../inc/conexionSingleton.php';

// Obtener la instancia única de la base de datos
$db = Database::getInstance();

// Obtener la conexión PDO
$pdo = $db->getConnection();

// Ahora puedes usar $pdo para ejecutar consultas SQL
try {
    $stmt = $pdo->prepare("SELECT bocadillos.nombre as 'bocadillo', DATE(pedidos.fecha) as 'fecha', bocadillos.tipo as 'tipo' FROM bocadillos, pedidos, alumnos WHERE pedidos.id_bocadillo= bocadillos.id AND pedidos.id_alumno=alumnos.id AND alumnos.id=1;");
    $stmt->execute();
    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($alumnos as $alumnos) {
        echo $alumnos['bocadillo'] . ' - ' . $alumnos['fecha'].' - ' . $alumnos['tipo'] . '<br>';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
