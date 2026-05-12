<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "centro_salud";

$conexion = new mysqli($host, $user, $pass, $db);
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if (isset($_POST['estado'])) {
    $estado = ($_POST['estado'] === '1') ? 1 : 0;

    // Insertar en la tabla `estados`
    $stmt = $conexion->prepare("INSERT INTO estados (estado) VALUES (?)");
    $stmt->bind_param("i", $estado);

    if ($stmt->execute()) {
        echo "Estado guardado: " . $estado;
    } else {
        echo "Error al insertar en la BD: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "No se recibió 'estado'.";
}

$conexion->close();
?>
