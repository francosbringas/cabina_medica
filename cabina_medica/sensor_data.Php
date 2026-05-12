<?php
date_default_timezone_set('America/Mexico_City')

$data = file_get_contents("php://input");
$timestamp = date("Y-m-d H:i:s");

file_put_contents("datos_sensores.txt", "[$timestamp] $data" . PHP_EOL, FILE_APPEND);

echo "Datos recibidos";
?>