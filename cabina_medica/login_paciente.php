<?php
header('Content-Type: application/json');
require 'conexion.php';

$dni = $_POST['dni'] ?? '';
$pin = $_POST['pin'] ?? '';

if (!$dni || !$pin) {
  echo json_encode(['success' => false, 'message' => 'DNI y PIN son obligatorios.']);
  exit;
}

// Preparar la consulta para obtener el PIN encriptado
$stmt = $mysqli->prepare("SELECT nombre, apellido, contrasena FROM pacientes WHERE dni = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Error en la consulta: ' . $mysqli->error]);
    exit;
}

$stmt->bind_param("i", $dni);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
  // Verificar el PIN
  if (password_verify($pin, $row['contrasena'])) {
    session_start();
    $_SESSION['dni_paciente'] = $dni; // <-- ESTA LÍNEA ES CLAVE
    echo json_encode([
      'success' => true,
      'message' => 'Inicio de sesión exitoso.',
      'nombre' => $row['nombre'],
      'apellido' => $row['apellido']
    ]);
  } else {
    echo json_encode(['success' => false, 'message' => 'DNI o PIN incorrecto.']);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'DNI o PIN incorrecto.']);
}
?>