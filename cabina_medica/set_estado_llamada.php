<?php
header('Content-Type: application/json');
require 'conexion.php';

$estado = isset($_POST['estado']) ? intval($_POST['estado']) : null;
$dni_paciente = isset($_POST['dni']) ? intval($_POST['dni']) : null;

if ($estado === null) {
  echo json_encode(['success' => false, 'message' => 'Falta estado']);
  exit;
}

if ($estado === 1) {
  if (!$dni_paciente) {
    echo json_encode(['success' => false, 'message' => 'Falta DNI del paciente']);
    exit;
  }
  $sql = "REPLACE INTO estado_llamada (id, estado, dni_paciente) VALUES (1, 1, ?)";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i", $dni_paciente);

} else if ($estado === 2) {
  if (!$dni_paciente) {
    echo json_encode(['success' => false, 'message' => 'Falta DNI del paciente']);
    exit;
  }
  $sql = "REPLACE INTO estado_llamada (id, estado, dni_paciente) VALUES (1, 2, ?)";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i", $dni_paciente);

} else {
  $sql = "REPLACE INTO estado_llamada (id, estado, dni_paciente) VALUES (1, 0, NULL)";
  $stmt = $mysqli->prepare($sql);
}

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
}
$stmt->close();
?>
