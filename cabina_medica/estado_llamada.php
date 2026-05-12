<?php
header('Content-Type: application/json');
require 'conexion.php';
$sql = "SELECT estado, dni_paciente FROM estado_llamada WHERE id = 1 LIMIT 1";
$res = $mysqli->query($sql);
if ($row = $res->fetch_assoc()) {
  echo json_encode([
    'success' => true,
    'estado' => intval($row['estado']),
    'dni_paciente' => $row['dni_paciente']
  ]);
} else {
  echo json_encode([
    'success' => false,
    'message' => 'No hay estado registrado'
  ]);
}
?>