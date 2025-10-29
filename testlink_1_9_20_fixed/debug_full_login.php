<?php
// Simular proceso completo de doAuthorize
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('php81_compatibility.inc.php');
include_once('config.inc.php');
require_once('common.php');

echo "<h1>Simulación completa de doAuthorize</h1>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['tl_login'] ?? '');
    $pwd = trim($_POST['tl_password'] ?? '');
    
    echo "<h2>Datos recibidos:</h2>";
    echo "<p>Login: <strong>$login</strong></p>";
    echo "<p>Password: <strong>[" . strlen($pwd) . " caracteres]</strong></p>";
    
    echo "<h2>Proceso paso a paso:</h2>";
    
    try {
        // Paso 1: Crear usuario y buscar en DB
        echo "<h3>1. Buscando usuario en base de datos</h3>";
        require_once('lib/functions/tlUser.class.php');
        require_once('lib/functions/doAuthorize.php');
        
        $user = new tlUser();
        $user->login = $login;
        
        echo "<p>Usuario creado: " . get_class($user) . "</p>";
        
        // Conectar a DB
        doDBConnect($db, database::ONERROREXIT);
        echo "<p style='color:green'>✅ Conexión DB establecida</p>";
        
        $searchBy = tlUser::USER_O_SEARCH_BYLOGIN;
        $loginExists = ($user->readFromDB($db, $searchBy) >= tl::OK);
        
        if ($loginExists) {
            echo "<p style='color:green'>✅ Usuario encontrado en DB</p>";
            echo "<p>ID: " . $user->dbID . "</p>";
            echo "<p>Login: " . $user->login . "</p>";
            echo "<p>Activo: " . ($user->isActive ? 'Sí' : 'No') . "</p>";
            echo "<p>Autenticación: " . $user->authentication . "</p>";
        } else {
            echo "<p style='color:red'>❌ Usuario NO encontrado</p>";
            die();
        }
        
        // Paso 2: Verificar password
        echo "<h3>2. Verificando password</h3>";
        $password_check = auth_does_password_match($db, $user, $pwd);
        
        echo "<p>Status: " . ($password_check->status_ok ? 'OK' : 'ERROR') . "</p>";
        echo "<p>Mensaje: " . $password_check->msg . "</p>";
        
        $doLogin = $password_check->status_ok && $user->isActive;
        
        if ($doLogin) {
            echo "<p style='color:green'>✅ Login autorizado</p>";
            
            // Paso 3: Crear sesión
            echo "<h3>3. Creando sesión</h3>";
            
            // Simular lo que hace doAuthorize después de login exitoso
            $_SESSION['currentUser'] = $user;
            $_SESSION['userID'] = $user->dbID;
            $_SESSION['login'] = $user->login;
            
            echo "<p style='color:green'>✅ Sesión creada</p>";
            echo "<p>Session ID: " . session_id() . "</p>";
            echo "<p>User ID en sesión: " . $_SESSION['userID'] . "</p>";
            
        } else {
            echo "<p style='color:red'>❌ Login NO autorizado</p>";
            echo "<p>Password OK: " . ($password_check->status_ok ? 'Sí' : 'No') . "</p>";
            echo "<p>Usuario activo: " . ($user->isActive ? 'Sí' : 'No') . "</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color:red'>❌ Error: " . $e->getMessage() . "</p>";
        echo "<p>Archivo: " . $e->getFile() . " línea " . $e->getLine() . "</p>";
    } catch (Error $e) {
        echo "<p style='color:red'>❌ Error fatal: " . $e->getMessage() . "</p>";
        echo "<p>Archivo: " . $e->getFile() . " línea " . $e->getLine() . "</p>";
    }
}

?>

<h2>Formulario de prueba completa</h2>
<form method="POST" action="">
    <p>
        <label>Usuario:</label><br>
        <input type="text" name="tl_login" value="arivera" style="padding:5px; width:200px;">
    </p>
    <p>
        <label>Contraseña:</label><br>
        <input type="password" name="tl_password" value="arivera" style="padding:5px; width:200px;">
    </p>
    <p>
        <input type="submit" value="Probar Login Completo" style="padding:10px; background:#007cba; color:white; border:none;">
    </p>
</form>

<h3>Estado actual de la sesión</h3>
<pre><?php print_r($_SESSION); ?></pre>