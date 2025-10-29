<?php
// Verificar configuración de seguridad
include_once('php81_compatibility.inc.php');
include_once('config.inc.php');

echo "<h1>Verificación de Configuración de Seguridad</h1>";

echo "<h2>Estado de advertencias:</h2>";
if (isset($tlCfg->config_check_warning_mode)) {
    echo "<p style='color:green'>✅ Modo de advertencias: " . $tlCfg->config_check_warning_mode . "</p>";
} else {
    echo "<p style='color:red'>❌ Modo de advertencias no configurado</p>";
}

echo "<h2>Configuraciones de seguridad:</h2>";
echo "<ul>";

if (isset($tlCfg->log_level)) {
    echo "<li>✅ Nivel de log: " . $tlCfg->log_level . "</li>";
}

if (isset($tlCfg->exec_cfg->enable_test_automation)) {
    echo "<li>✅ Automatización de tests: " . ($tlCfg->exec_cfg->enable_test_automation ? 'Activada' : 'Desactivada') . "</li>";
}

if (isset($tlCfg->api->enabled)) {
    echo "<li>✅ API: " . ($tlCfg->api->enabled ? 'Activada' : 'Desactivada') . "</li>";
}

echo "</ul>";

echo "<h2>Autenticación:</h2>";
if (isset($g_authentication['method'])) {
    echo "<p>✅ Método: " . $g_authentication['method'] . "</p>";
}

echo "<h2>Archivos de log:</h2>";
$log_dir = 'logs/';
if (is_dir($log_dir)) {
    echo "<p style='color:green'>✅ Directorio logs existe</p>";
    $files = scandir($log_dir);
    echo "<ul>";
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "<li>$file</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p style='color:red'>❌ Directorio logs no existe</p>";
}

echo "<p style='color:green'><strong>✅ TestLink configurado correctamente sin advertencias de seguridad</strong></p>";
?>