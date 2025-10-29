<?php
// Test específico para comparePassword
include_once('php81_compatibility.inc.php');
include_once('config.inc.php');
require_once('lib/functions/common.php');

echo "<h1>Debug comparePassword TestLink</h1>";

// Simular el proceso exacto que hace TestLink
echo "<h2>1. Probando hashes en base de datos</h2>";

$conn = new mysqli('localhost', 'root', '', 'testlink');
$result = $conn->query("SELECT login, password FROM users WHERE login IN ('admin', 'arivera')");

while ($row = $result->fetch_assoc()) {
    $login = $row['login'];
    $stored_hash = $row['password'];
    
    echo "<h3>Usuario: $login</h3>";
    echo "<p>Hash almacenado: $stored_hash</p>";
    echo "<p>Longitud del hash: " . strlen($stored_hash) . " caracteres</p>";
    
    // Probar contraseñas
    $test_passwords = [$login, 'admin', 'arivera'];
    
    foreach ($test_passwords as $pwd) {
        echo "<h4>Probando contraseña: '$pwd'</h4>";
        
        // Test MD5
        $md5_hash = md5($pwd);
        echo "<p>MD5 de '$pwd': $md5_hash</p>";
        
        if ($stored_hash === $md5_hash) {
            echo "<p style='color:green'>✅ MD5 coincide!</p>";
        } else {
            echo "<p style='color:red'>❌ MD5 NO coincide</p>";
        }
        
        // Test password_verify 
        if (password_verify($pwd, $stored_hash)) {
            echo "<p style='color:green'>✅ password_verify() funciona</p>";
        } else {
            echo "<p style='color:red'>❌ password_verify() falla</p>";
        }
        
        echo "<hr>";
    }
    
    echo "<br><br>";
}

$conn->close();

echo "<h2>2. Simulando proceso comparePassword exacto</h2>";

class TestUser {
    public $password;
    public $authentication = 'MD5';
    
    public function getPassword() {
        return $this->password;
    }
    
    public function encryptPassword($pwd, $auth) {
        return password_hash($pwd, PASSWORD_DEFAULT);
    }
    
    public function comparePasswordSim($pwd) {
        $encriptedPWD = $this->getPassword();
        echo "<p>Password almacenado: $encriptedPWD</p>";
        echo "<p>Longitud: " . strlen($encriptedPWD) . "</p>";
        
        if (strlen($encriptedPWD) == 32) {
            echo "<p style='color:blue'>ℹ️ Hash de 32 caracteres detectado (MD5)</p>";
            $md5_test = md5($pwd);
            echo "<p>MD5 de entrada: $md5_test</p>";
            
            if ($encriptedPWD === $md5_test) {
                echo "<p style='color:green'>✅ MD5 coincide - Login exitoso</p>";
                return true;
            } else {
                echo "<p style='color:red'>❌ MD5 NO coincide</p>";
            }
        }
        
        if (password_verify($pwd, $encriptedPWD)) {
            echo "<p style='color:green'>✅ password_verify exitoso</p>";
            return true;
        } else {
            echo "<p style='color:red'>❌ password_verify falla</p>";
        }
        
        return false;
    }
}

// Probar con datos reales
$test_user = new TestUser();

echo "<h3>Probando usuario arivera</h3>";
$test_user->password = 'd67296517c98b5fbd4e7b87c20dc2d1b';
$result = $test_user->comparePasswordSim('arivera');
echo "<p><strong>Resultado final: " . ($result ? 'ÉXITO' : 'FALLO') . "</strong></p>";

echo "<h3>Probando usuario admin</h3>";
$test_user->password = '21232f297a57a5a743894a0e4a801fc3';
$result = $test_user->comparePasswordSim('admin');
echo "<p><strong>Resultado final: " . ($result ? 'ÉXITO' : 'FALLO') . "</strong></p>";

?>