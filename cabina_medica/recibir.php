<?php

header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$db   = "centro_salud";

$conexion = new mysqli($host, $user, $pass, $db);
if ($conexion->connect_error) {
    // En caso de error de conexión, devolvemos estado 0 por defecto
    echo json_encode(['estado' => 0]);
    exit;
}

// Obtenemos el último registro (el de mayor id) de la tabla `estados`
$query = "SELECT estado FROM estados ORDER BY id DESC LIMIT 1";
$result = $conexion->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $ultimo = intval($row['estado']);
    echo json_encode(['estado' => $ultimo]);
} else {
    // Si no hay filas, devolvemos 0
    echo json_encode(['estado' => 0]);
}

$conexion->close();
?>
