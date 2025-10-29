<?php
// Debug específico para el proceso de login
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir compatibilidad PHP 8.1
include_once('php81_compatibility.inc.php');

echo "<h1>Debug Login TestLink</h1>";

// Mostrar datos POST si existen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>Datos POST recibidos:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    $login = $_POST['tl_login'] ?? '';
    $password = $_POST['tl_password'] ?? '';
    
    echo "<p>Usuario: <strong>" . htmlspecialchars($login) . "</strong></p>";
    echo "<p>Password: <strong>[" . strlen($password) . " caracteres]</strong></p>";
    echo "<p>Password MD5: <strong>" . md5($password) . "</strong></p>";
}

echo "<h2>1. Verificando inicialización básica</h2>";

try {
    // Incluir config básico
    include_once('config.inc.php');
    echo "<p style='color:green'>✅ config.inc.php incluido</p>";
    
    if (isset($tlCfg)) {
        echo "<p style='color:green'>✅ \$tlCfg inicializado</p>";
    } else {
        echo "<p style='color:red'>❌ \$tlCfg NO inicializado</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Error incluyendo config: " . $e->getMessage() . "</p>";
} catch (Error $e) {
    echo "<p style='color:red'>❌ Error fatal en config: " . $e->getMessage() . "</p>";
}

echo "<h2>2. Probando conexión directa a base de datos</h2>";

try {
    $conn = new mysqli('localhost', 'root', '', 'testlink');
    if ($conn->connect_error) {
        echo "<p style='color:red'>❌ Error MySQL: " . $conn->connect_error . "</p>";
    } else {
        echo "<p style='color:green'>✅ Conexión MySQL exitosa</p>";
        
        // Verificar usuarios
        $result = $conn->query("SELECT login, password, active, role_id FROM users WHERE login IN ('admin', 'arivera')");
        if ($result) {
            echo "<h3>Usuarios en la base de datos:</h3>";
            echo "<table border='1' style='border-collapse:collapse'>";
            echo "<tr><th>Login</th><th>Password Hash</th><th>Activo</th><th>Role ID</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['login']) . "</td>";
                echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                echo "<td>" . ($row['active'] ? 'Sí' : 'No') . "</td>";
                echo "<td>" . $row['role_id'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
        $conn->close();
    }
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Error conectando: " . $e->getMessage() . "</p>";
}

echo "<h2>3. Verificando archivos de autenticación</h2>";

$auth_files = [
    'lib/functions/authentication.php',
    'lib/functions/users.inc.php',
    'lib/users/users.inc.php'
];

foreach ($auth_files as $file) {
    if (file_exists($file)) {
        echo "<p style='color:green'>✅ $file existe</p>";
    } else {
        echo "<p style='color:red'>❌ $file NO existe</p>";
    }
}

// Si hay datos POST, simular autenticación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['tl_login'])) {
    echo "<h2>4. Simulando proceso de autenticación</h2>";
    
    $login = $_POST['tl_login'];
    $password = $_POST['tl_password'];
    $password_md5 = md5($password);
    
    echo "<p>Buscando usuario: <strong>$login</strong></p>";
    echo "<p>Password MD5 esperado: <strong>$password_md5</strong></p>";
    
    try {
        $conn = new mysqli('localhost', 'root', '', 'testlink');
        $stmt = $conn->prepare("SELECT id, login, password, active, role_id FROM users WHERE login = ? AND active = 1");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            echo "<p style='color:green'>✅ Usuario encontrado en DB</p>";
            echo "<p>Password en DB: <strong>" . $row['password'] . "</strong></p>";
            echo "<p>Password enviado: <strong>$password_md5</strong></p>";
            
            if ($row['password'] === $password_md5) {
                echo "<p style='color:green'>✅ Password coincide</p>";
                echo "<p style='color:green'>✅ Login debería ser exitoso</p>";
            } else {
                echo "<p style='color:red'>❌ Password NO coincide</p>";
                echo "<p>Probemos otros hashes:</p>";
                echo "<p>SHA1: " . sha1($password) . "</p>";
                echo "<p>Plain: $password</p>";
            }
        } else {
            echo "<p style='color:red'>❌ Usuario NO encontrado o inactivo</p>";
        }
        
        $conn->close();
        
    } catch (Exception $e) {
        echo "<p style='color:red'>❌ Error en autenticación: " . $e->getMessage() . "</p>";
    }
}

?>

<!-- Formulario de prueba -->
<h2>5. Formulario de prueba</h2>
<form method="POST" action="">
    <p>
        <label>Usuario:</label><br>
        <input type="text" name="tl_login" value="arivera" style="padding:5px;">
    </p>
    <p>
        <label>Contraseña:</label><br>
        <input type="password" name="tl_password" value="arivera" style="padding:5px;">
    </p>
    <p>
        <input type="submit" value="Probar Login" style="padding:10px;">
    </p>
</form>