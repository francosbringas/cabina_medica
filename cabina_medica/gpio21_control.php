<?php
$action = $_POST['action'] ?? '';
if ($action === 'on') {
    exec('"C:\xampp\htdocs\cabina_medica\activar_gpio_21.bat"');
    echo "ON";
} elseif ($action === 'off') {
    exec('"C:\xampp\htdocs\cabina_medica\apagar_gpio_21.bat"');
    echo "OFF";
} else {
    http_response_code(400);
    echo "Parámetro inválido";
}
?>