<?php
header('Content-Type: application/json');
require 'conexion.php';
$dni      = $_POST['dni']      ?? '';
$nombre   = $_POST['nombre']   ?? '';
$apellido = $_POST['apellido'] ?? '';
$pin      = $_POST['pin']      ?? '';
if (!$dni||!$nombre||!$apellido) {
  echo json_encode(['success'=>false,'message'=>'Completa todos los campos.']); exit;
}
if (!preg_match('/^\d{4}$/',$pin)) {
  echo json_encode(['success'=>false,'message'=>'El PIN debe tener 4 dígitos numéricos.']); exit;
}
$stmt=$mysqli->prepare("INSERT INTO medicos (dni,nombre,apellido,contrasena) VALUES(?,?,?,?)");
$stmt->bind_param("isss",$dni,$nombre,$apellido,$pin);
if($stmt->execute()){
  echo json_encode(['success'=>true,'message'=>'¡Médico registrado con éxito!']);
}else{
  echo json_encode(['success'=>false,'message'=>'Error: '.$stmt->error]);
}
?>
