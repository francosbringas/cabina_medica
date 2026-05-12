<?php
header('Content-Type: application/json');
require 'conexion.php';
$dni=$_GET['dni']??'';
$stmt=$mysqli->prepare(
  "SELECT temperatura,fecha
   FROM diagnosticos
   WHERE dni_paciente=?
   ORDER BY fecha DESC LIMIT 1"
);
$stmt->bind_param("s",$dni);
$stmt->execute();
$res=$stmt->get_result();
if($row=$res->fetch_assoc()){
  echo json_encode(['success'=>true,'resultado'=>$row]);
}else{
  echo json_encode(['success'=>false]);
}
?>
