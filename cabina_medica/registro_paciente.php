<?php
header('Content-Type: application/json');
include 'conexion.php';

$dni = $_POST['dni'];
$pin = $_POST['pin'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];

// Verificar si el DNI ya existe
$sql = "SELECT * FROM pacientes WHERE dni = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $dni);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Ese DNI ya está en uso']);
    exit;
}

// Encriptar el PIN
$hashedPin = password_hash($pin, PASSWORD_DEFAULT);

// Insertar nuevo paciente
$insert = "INSERT INTO pacientes (dni, contrasena, nombre, apellido) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($insert);
$stmt->bind_param("isss", $dni, $hashedPin, $nombre, $apellido);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Registro exitoso']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al registrar paciente: ' . $stmt->error]);
}
?>
