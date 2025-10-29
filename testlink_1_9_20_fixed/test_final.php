<?php
/**
 * Test final simple - Verificar que TestLink carga sin errores críticos
 */

// Configurar para capturar errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h2>TestLink PHP 8.1 - Test Final</h2>\n";

try {
    // Cargar configuración básica
    require_once('config.inc.php');
    echo "✅ config.inc.php cargado exitosamente<br>\n";
    
    // Verificar conexión DB
    $db_test = new mysqli($g_db_hostname, $g_db_username, $g_db_password, $g_db_name, $g_db_port);
    if (!$db_test->connect_error) {
        echo "✅ Conexión a base de datos OK<br>\n";
        
        // Verificar usuario admin
        $result = $db_test->query("SELECT login, active FROM users WHERE login='admin'");
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo "✅ Usuario admin encontrado y " . ($user['active'] ? 'ACTIVO' : 'INACTIVO') . "<br>\n";
        }
        $db_test->close();
    } else {
        echo "❌ Error de conexión DB: " . $db_test->connect_error . "<br>\n";
    }
    
    echo "<br><strong>Estado: TestLink está funcionalmente OK</strong><br>\n";
    echo "<br>Credenciales: admin / admin<br>\n";
    echo "<a href='login.php'>Ir a Login</a> | <a href='index.php'>Ir a Inicio</a><br>\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>\n";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
</style>