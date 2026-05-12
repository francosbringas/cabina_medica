<?php
header('Content-Type: application/json');

$ip='10.0.201.201';
$user='admin';
$password='06478955';

$port = isset($_POST['port']) ? intval($_POST['port']) : 0;
$action = isset($_POST['action']) ? strtolower(trim($_POST['action'])) : '';

if (!in_array($port, [1, 3]) || !in_array($action, ['on', 'off'])) {
    echo json_encode(['success' => false, 'message' => 'Parámetros inválidos']);
    exit;
}

$puerto = "p6{$port}";
$estado = $action === 'on' ? 1 : 0;
$url = "http://{$ip}/set.cmd?user={$user}+pass={$password}+cmd=setpower+{$puerto}={$estado}";

$response = @file_get_contents($url);

if ($response === false) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al conectar o controlar la EPDU',
        'url' => $url
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => "Acción ejecutada: {$action} en puerto {$port}.",
    'url' => $url,
    'response' => $response
]);
?>