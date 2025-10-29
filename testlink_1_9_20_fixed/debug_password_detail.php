<?php
// Debug específico del password checking
echo "=== DEBUG PASSWORD ESPECÍFICO ===\n";

// Simular variables POST
$_POST['tl_login'] = 'arivera';
$_POST['tl_password'] = 'arivera';

// Incluir archivos necesarios
include_once('php81_compatibility.inc.php');
include_once('config.inc.php');
require_once('common.php');

// Conectar a DB
doDBConnect($db, database::ONERROREXIT);
echo "DB conectada\n";

// Crear usuario y leer de DB
require_once('lib/functions/tlUser.class.php');
$user = new tlUser();
$user->login = $_POST['tl_login'];
$user->readFromDB($db, tlUser::USER_O_SEARCH_BYLOGIN);

echo "Usuario cargado:\n";
echo "- ID: " . $user->dbID . "\n";
echo "- Login: " . $user->login . "\n";
echo "- Authentication: '" . $user->authentication . "'\n";

// Obtener password real de la DB
$stored_password = $user->getPassword();
echo "- Password almacenado: " . $stored_password . "\n";
echo "- Longitud password: " . strlen($stored_password) . "\n";

// Probar nuestro password
$test_password = $_POST['tl_password'];
echo "\nProbando password: '$test_password'\n";
echo "- MD5 del password: " . md5($test_password) . "\n";

// Test manual del algoritmo comparePassword
echo "\n=== SIMULANDO comparePassword ===\n";

// Verificar si es MD5 (32 caracteres)
if (strlen($stored_password) == 32) {
    echo "Password de 32 caracteres detectado (MD5)\n";
    
    $md5_test = md5($test_password);
    echo "MD5 de entrada: $md5_test\n";
    echo "MD5 almacenado: $stored_password\n";
    
    if ($stored_password === $md5_test) {
        echo "✅ MD5 COINCIDE\n";
    } else {
        echo "❌ MD5 NO COINCIDE\n";
    }
}

// Test con password_verify
echo "\nTest password_verify:\n";
if (password_verify($test_password, $stored_password)) {
    echo "✅ password_verify OK\n";
} else {
    echo "❌ password_verify FALLA\n";
}

// Llamar al método real comparePassword
echo "\n=== LLAMANDO comparePassword REAL ===\n";
$result = $user->comparePassword($db, $test_password);
echo "Resultado comparePassword: $result\n";

if ($result == tl::OK) {
    echo "✅ comparePassword EXITOSO\n";
} else {
    echo "❌ comparePassword FALLÓ\n";
    echo "Valor retornado: $result\n";
    
    // Verificar constantes
    echo "tl::OK = " . tl::OK . "\n";
    
    // Verificar método de autenticación
    echo "Método auth user: '" . $user->authentication . "'\n";
    
    // Verificar si es password externo
    echo "¿Es password externo? ";
    if (tlUser::isPasswordMgtExternal($user->authentication)) {
        echo "SÍ\n";
    } else {
        echo "NO\n";
    }
}

echo "\n=== FIN DEBUG ===\n";
?>