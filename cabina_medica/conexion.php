<?php
$mysqli = new mysqli("localhost", "root", "", "centro_salud");
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}
?>
