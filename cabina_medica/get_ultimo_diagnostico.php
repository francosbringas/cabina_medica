<?php
require 'conexion.php';

$dni_paciente = isset($_GET['dni_paciente']) ? intval($_GET['dni_paciente']) : 0;
if ($dni_paciente === 0) {
    echo json_encode(['success'=>false, 'msg'=>'DNI inválido']);
    exit;
}

$sql = "SELECT fecha, temperatura FROM diagnostico WHERE dni_paciente=? ORDER BY fecha DESC LIMIT 1";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $dni_paciente);
$stmt->execute();
$stmt->bind_result($fecha, $temperatura);

if ($stmt->fetch()) {
    echo json_encode(['success'=>true, 'fecha'=>$fecha, 'temperatura'=>$temperatura]);
} else {
    echo json_encode(['success'=>false, 'msg'=>'Sin diagnósticos']);
}
$stmt->close();
?>