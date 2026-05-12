<?php
header('Content-Type: application/json');
require 'conexion.php';


$query = "SELECT estado FROM sensor_silla WHERE id = 1 LIMIT 1";
$result = $mysqli->query($query);

if ($result && $row = $result->fetch_assoc()) {
    echo json_encode(['estado' => (int)$row['estado']]);
} else {
    echo json_encode(['estado' => 0]);
}
?>
