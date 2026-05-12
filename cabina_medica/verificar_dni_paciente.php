<?php
require 'conexion.php';

$dni = $_GET['dni'] ?? '';

$stmt = $mysqli->prepare("SELECT dni FROM pacientes WHERE dni = ?");
$stmt->bind_param("i", $dni);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  echo json_encode(['existe' => true]);
} else {
  echo json_encode(['existe' => false]);
}
$stmt->close();
$mysqli->close();
