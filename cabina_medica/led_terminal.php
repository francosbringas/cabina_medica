<?php
$color = $_POST['color'] ?? '';
if ($color === 'blanco') {
    exec ('C:\xampp\htdocs\cabina_medica\led_blanco.bat');
} elseif ($color === 'rojo') {
    exec('C:\xampp\htdocs\cabina_medica\led_rojo.bat');
} else {
    hhtp_response_code(400); exit("Color inválido");
}
echo "OK"
?>