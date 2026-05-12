<?php
header('Content-Type: application/json');
$output = [];
exec('"C:\xampp\htdocs\cabina_medica\gpio1.bat"', $output, $retval);

// Si NO hay salida o el BAT falló, devuelve -1
if ($retval !== 0 || empty($output)) {
    echo json_encode(['estado' => -1, 'error' => true]);
    exit;
}

// Busca el primer número (0 o 1) en la salida
if (preg_match('/\b([01])\b/', implode("\n", $output), $matches)) {
    $estado = intval($matches[1]);
    echo json_encode(['estado' => $estado]);
    exit;
}

// Si nada coincide, también devuelve -1
echo json_encode(['estado' => -1, 'error' => true]);
?>