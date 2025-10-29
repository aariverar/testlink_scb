<?php
// Debug específico para la inicialización de TestLink
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

echo "<h1>Debug Inicialización TestLink</h1>";

echo "<h2>1. Verificando compatibilidad PHP 8.1</h2>";
if (file_exists('php81_compatibility.inc.php')) {
    echo "<p>Incluyendo php81_compatibility.inc.php...</p>";
    include_once('php81_compatibility.inc.php');
    echo "<p style='color:green'>✅ Compatibilidad PHP 8.1 cargada</p>";
} else {
    echo "<p style='color:red'>❌ php81_compatibility.inc.php NO encontrado</p>";
}

echo "<h2>2. Verificando TL_ABS_PATH</h2>";
$tl_abs_path = dirname(__FILE__) . DIRECTORY_SEPARATOR;
echo "<p>TL_ABS_PATH: $tl_abs_path</p>";

echo "<h2>3. Verificando archivo custom_config.inc.php</h2>";
$custom_config_file = $tl_abs_path . 'custom_config.inc.php';
echo "<p>Ruta: $custom_config_file</p>";
if (file_exists($custom_config_file)) {
    echo "<p style='color:green'>✅ custom_config.inc.php existe</p>";
    echo "<p>Tamaño: " . filesize($custom_config_file) . " bytes</p>";
} else {
    echo "<p style='color:red'>❌ custom_config.inc.php NO existe</p>";
}

echo "<h2>4. Probando inclusión paso a paso</h2>";

// Probar const.inc.php
$const_file = $tl_abs_path . 'cfg' . DIRECTORY_SEPARATOR . 'const.inc.php';
echo "<p>Probando: $const_file</p>";
if (file_exists($const_file)) {
    try {
        include_once($const_file);
        echo "<p style='color:green'>✅ const.inc.php incluido</p>";
    } catch (Exception $e) {
        echo "<p style='color:red'>❌ Error en const.inc.php: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color:red'>❌ const.inc.php NO existe</p>";
}

// Probar custom_config.inc.php
if (file_exists($custom_config_file)) {
    echo "<p>Probando inclusión de custom_config.inc.php...</p>";
    try {
        include_once($custom_config_file);
        echo "<p style='color:green'>✅ custom_config.inc.php incluido exitosamente</p>";
        
        if (isset($db)) {
            echo "<p style='color:green'>✅ Variable \$db definida</p>";
        } else {
            echo "<p style='color:red'>❌ Variable \$db NO definida</p>";
        }
        
        if (isset($g_tlLogger)) {
            echo "<p style='color:green'>✅ Variable \$g_tlLogger definida</p>";
        } else {
            echo "<p style='color:red'>❌ Variable \$g_tlLogger NO definida</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color:red'>❌ Error en custom_config.inc.php: " . $e->getMessage() . "</p>";
    } catch (Error $e) {
        echo "<p style='color:red'>❌ Error fatal en custom_config.inc.php: " . $e->getMessage() . "</p>";
    }
}

echo "<h2>5. Verificando base de datos</h2>";
if (extension_loaded('mysqli')) {
    echo "<p style='color:green'>✅ Extensión mysqli cargada</p>";
    
    // Probar conexión directa
    try {
        $conn = new mysqli('localhost', 'root', '', 'testlink');
        if ($conn->connect_error) {
            echo "<p style='color:red'>❌ Error de conexión: " . $conn->connect_error . "</p>";
        } else {
            echo "<p style='color:green'>✅ Conexión a base de datos exitosa</p>";
            $conn->close();
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>❌ Error conectando DB: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color:red'>❌ Extensión mysqli NO cargada</p>";
}

?>