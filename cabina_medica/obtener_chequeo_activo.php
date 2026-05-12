<?php
require_once 'conexion.php';

$sql = "SELECT chequeo_activo FROM estado_chequeo WHERE id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["chequeo_activo" => $row['chequeo_activo']]);
} else {
    echo json_encode(["chequeo_activo" => null]);
}
?>
