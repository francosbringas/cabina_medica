<?php
header('Content-Type: application/json');
if (!isset($_GET['dni'])) {
  echo json_encode(['success'=>false,'message'=>'Falta DNI']);
  exit;
}
$dni = intval($_GET['dni']);
$conn = new mysqli("localhost", "root", "", "centro_salud");
if ($conn->connect_errno) {
  echo json_encode(['success'=>false,'message'=>'Error BD']);
  exit;
}
$stmt = $conn->prepare("SELECT nombre, apellido FROM pacientes WHERE dni = ?");
$stmt->bind_param('i', $dni);
$stmt->execute();
$stmt->bind_result($nombre, $apellido);
if ($stmt->fetch()) {
  echo json_encode(['success'=>true,'nombre'=>$nombre,'apellido'=>$apellido]);
} else {
  echo json_encode(['success'=>false,'message'=>'Paciente no encontrado']);
}
$stmt->close();
$conn->close();
