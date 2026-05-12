<?php

$estado = (isset($_POST['estado']) && $_POST['estado'] === '1') ? 1 : 0;

$host = "localhost";
$user = "root";
$pass = "";
$db   = "centro_salud";

$conexion = new mysqli($host, $user, $pass, $db);
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$sql = "INSERT INTO estados (estado) VALUES ($estado)";

if ($conexion->query($sql) === TRUE) {
    echo "Estado $estado registrado correctamente";
} else {
    echo "Error al registrar estado: " . $conexion->error;
}

$conexion->close();
?>
