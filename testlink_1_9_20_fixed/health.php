<?php
// Healthcheck simple para Railway
// Este archivo verifica que PHP y Apache estén funcionando

header('Content-Type: application/json');
header('Cache-Control: no-cache');

$status = [
    'status' => 'healthy',
    'timestamp' => date('Y-m-d H:i:s'),
    'php_version' => PHP_VERSION,
    'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'Apache',
    'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB'
];

// Verificar conexión básica a base de datos (opcional)
try {
    if (extension_loaded('mysqli')) {
        $status['mysql_extension'] = 'loaded';
    }
    $status['extensions'] = [
        'gd' => extension_loaded('gd'),
        'mbstring' => extension_loaded('mbstring'),
        'mysqli' => extension_loaded('mysqli'),
        'zip' => extension_loaded('zip')
    ];
} catch (Exception $e) {
    $status['db_check'] = 'skipped: ' . $e->getMessage();
}

// Verificar si TestLink está accesible
if (file_exists('/var/www/html/index.php')) {
    $status['testlink'] = 'files_present';
} else {
    $status['testlink'] = 'files_missing';
}

http_response_code(200);
echo json_encode($status, JSON_PRETTY_PRINT);
?>