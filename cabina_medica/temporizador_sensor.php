<?php

$port = isset($_GET['port']) ? intval($_GET['port']) : 0;
if ($port < 1 || $port > 8) {
    echo json_encode(['success'=>false, 'message'=>'Puerto inválido']);
    exit;
}

file_get_contents("http://localhost/ipower_control.php?port=$port");

sleep(60);

file_get_contents("http://localhost/ipower_control.php?port=$port");

echo json_encode(['success'=>true, 'message'=>"Sensor en puerto $port activado por 2 minutos"]);
?>