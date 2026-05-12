<?php
require 'conexion.php';
$tipo=$_POST['tipo']??'';
if(in_array($tipo,['oximetria','temperatura','pulso'])){
  $mysqli->query("UPDATE estado_chequeo SET chequeo_activo='$tipo' WHERE id=1");
}
?>
