<?php
require 'conexion.php';
session_start();

if (!isset($_POST['dni_paciente']) || !isset($_POST['temperatura'])) {
    echo json_encode(['success'=>false, 'msg'=>'Datos incompletos']);
    exit;
}

$dni_medico = $_SESSION['dni_medico'] ?? null;
if (!$dni_medico) {
    echo json_encode(['success'=>false, 'msg'=>'No autenticado como médico']);
    exit;
}

$dni_paciente = intval($_POST['dni_paciente']);
$temperatura = floatval($_POST['temperatura']);
$fecha = date('Y-m-d');

$sql = "INSERT INTO diagnosticos (dni_paciente, dni_medico, fecha, temperatura) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iisd", $dni_paciente, $dni_medico, $fecha, $temperatura);

if ($stmt->execute()) {
    echo json_encode(['success'=>true]);
} else {
    echo json_encode(['success'=>false, 'msg'=>'Error al guardar']);
}
$stmt->close();
?>