<?php
// Test login directo sin servidor web
echo "=== TEST LOGIN DIRECTO ===\n";

// Simular variables POST
$_POST['tl_login'] = 'arivera';
$_POST['tl_password'] = 'arivera';
$_SERVER['REQUEST_METHOD'] = 'POST';

// Incluir archivos necesarios
include_once('php81_compatibility.inc.php');
include_once('config.inc.php');
require_once('common.php');
require_once('lib/functions/doAuthorize.php');

echo "1. Archivos incluidos correctamente\n";

// Conectar a DB
doDBConnect($db, database::ONERROREXIT);
echo "2. Conexión DB establecida\n";

// Crear usuario
require_once('lib/functions/tlUser.class.php');
$user = new tlUser();
$user->login = $_POST['tl_login'];

// Buscar usuario
$loginExists = ($user->readFromDB($db, tlUser::USER_O_SEARCH_BYLOGIN) >= tl::OK);
echo "3. Usuario encontrado: " . ($loginExists ? 'SÍ' : 'NO') . "\n";

if ($loginExists) {
    echo "   - ID: " . $user->dbID . "\n";
    echo "   - Login: " . $user->login . "\n";
    echo "   - Activo: " . ($user->isActive ? 'SÍ' : 'NO') . "\n";
    echo "   - Auth: " . $user->authentication . "\n";
    
    // Verificar password
    $password_check = auth_does_password_match($db, $user, $_POST['tl_password']);
    echo "4. Password check: " . ($password_check->status_ok ? 'OK' : 'ERROR') . "\n";
    
    $doLogin = $password_check->status_ok && $user->isActive;
    echo "5. Login autorizado: " . ($doLogin ? 'SÍ' : 'NO') . "\n";
    
    if ($doLogin) {
        echo "\n✅ LOGIN EXITOSO ✅\n";
        echo "El usuario " . $user->login . " puede acceder al sistema.\n";
    } else {
        echo "\n❌ LOGIN FALLÓ ❌\n";
        echo "Razón: ";
        if (!$password_check->status_ok) echo "Password incorrecto";
        if (!$user->isActive) echo "Usuario inactivo";
        echo "\n";
    }
} else {
    echo "\n❌ USUARIO NO ENCONTRADO ❌\n";
}

echo "\n=== FIN TEST ===\n";
?>