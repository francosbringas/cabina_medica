<?php
session_start();
header('Content-Type: application/json');
require 'conexion.php';

$dni = $_POST['dni'] ?? '';
$pin = $_POST['pin'] ?? '';

if (!$dni || !$pin) {
  echo json_encode(['success' => false, 'message' => 'DNI y PIN obligatorios.']);
  exit;
}

$stmt = $mysqli->prepare("SELECT dni, apellido FROM medicos WHERE dni = ? AND contrasena = ?");
$stmt->bind_param("is", $dni, $pin);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
  $_SESSION['dni_medico'] = $row['dni'];
  echo json_encode([
    'success' => true,
    'message' => 'Inicio de sesión exitoso.',
    'apellido' => $row['apellido'],
    'dni' => $row['dni']
  ]);
} else {
  echo json_encode(['success' => false, 'message' => 'DNI o PIN incorrecto.']);
}
?>