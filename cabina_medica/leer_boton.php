<?php
header('Content-Type: application/json');

$gpio = 17;

$path = "/sys/class/gpio/gpio$gpio/value";

if (!file_exists($path)) {
    file_put_contents('/sys/class/gpio/export', $gpio);
    usleep(100000);
    file_put_contents("/sys/class/gpio/gpio$gpio/direction", "in");
}

$value = trim(@file_get_contents($path));
echo json_encode(["estado" => $value !== false ? (int)$value : -1]);
?>
