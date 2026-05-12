<?php
require 'conexion.php';

$dni_paciente = $_GET['dni_paciente'] ?? '';
$dni_medico = $_GET['dni_medico'] ?? '';

if (!$dni_paciente || !$dni_medico) {
    echo json_encode(["error" => "Faltan parámetros"]);
    exit;
}

$query = "SELECT temperatura, oximetria, pulso, fecha FROM diagnosticos
          WHERE dni_paciente = ? AND dni_medico = ?
          ORDER BY fecha DESC LIMIT 1";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("ss", $dni_paciente, $dni_medico);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["error" => "No se encontraron resultados"]);
}

$stmt->close();
$mysqli->close();
?>
