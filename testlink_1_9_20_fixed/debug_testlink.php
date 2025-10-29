<?php
// Debug PHP para TestLink
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

echo "<h1>Debug TestLink</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";

echo "<h2>Probando inclusión de archivos de TestLink:</h2>";

// Probar incluir config
echo "<p>Intentando incluir config.inc.php...</p>";
try {
    include_once('config.inc.php');
    echo "<p style='color:green'>✅ config.inc.php incluido exitosamente</p>";
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Error en config.inc.php: " . $e->getMessage() . "</p>";
} catch (Error $e) {
    echo "<p style='color:red'>❌ Error fatal en config.inc.php: " . $e->getMessage() . "</p>";
}

echo "<h2>Variables definidas:</h2>";
if (isset($g_tlLogger)) {
    echo "<p style='color:green'>✅ \$g_tlLogger definido</p>";
} else {
    echo "<p style='color:red'>❌ \$g_tlLogger NO definido</p>";
}

if (isset($db)) {
    echo "<p style='color:green'>✅ \$db definido</p>";
} else {
    echo "<p style='color:red'>❌ \$db NO definido</p>";
}

echo "<h2>Archivos requeridos:</h2>";
$required_files = [
    'config.inc.php',
    'custom_config.inc.php', 
    'lib/functions/common.php',
    'index.php'
];

foreach ($required_files as $file) {
    if (file_exists($file)) {
        echo "<p style='color:green'>✅ $file existe</p>";
    } else {
        echo "<p style='color:red'>❌ $file NO existe</p>";
    }
}

?>