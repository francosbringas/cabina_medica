<?php
header('Content-type: apliccation/json');
file_put_contents("debug.log", print_r($_POST, true) . "\n", FILE_APPEND);
$gpio = isset($_POST['gpio']) ? intval($_POST['gpio']) : null;

$cmd = '"C:\xampp\htdocs\cabina_medica\activar_gpio_' . $gpio . '.bat"';
$output = [];
$return_var = 0;
exec($cmd . " > bat_output.log 2>&1", $output, $return_var);
file_put_contents("php_output.log", print_r($output, true) . "\nReturn code: $return_var\n", FILE_APPEND);
echo "OK";
?>