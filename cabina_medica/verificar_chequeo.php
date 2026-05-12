<?php
require 'conexion.php';
$row=$mysqli->query("SELECT chequeo_activo FROM estado_chequeo WHERE id=1")->fetch_assoc();
echo json_encode(['chequeo_activo'=>$row['chequeo_activo']]);
?>
