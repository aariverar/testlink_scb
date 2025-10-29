<?php
// Debug configuración de autenticación
include_once('php81_compatibility.inc.php');
include_once('config.inc.php');

echo "=== DEBUG CONFIGURACIÓN AUTENTICACIÓN ===\n";

$authCfg = config_get('authentication');

echo "Configuración completa:\n";
print_r($authCfg);

echo "\n=== VERIFICANDO MÉTODOS ===\n";

$methods_to_check = ['MD5', 'DB', '', null];

foreach ($methods_to_check as $method) {
    echo "Método: '$method'\n";
    $is_external = tlUser::isPasswordMgtExternal($method);
    echo "¿Es externo? " . ($is_external ? 'SÍ' : 'NO') . "\n";
    echo "---\n";
}

echo "\n=== FIN DEBUG ===\n";
?>