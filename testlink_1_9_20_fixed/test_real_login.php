<?php
// Test POST real al login de TestLink
echo "<h1>Test POST real a login.php</h1>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>Enviando datos al login real de TestLink...</h2>";
    
    $login_data = array(
        'tl_login' => $_POST['tl_login'],
        'tl_password' => $_POST['tl_password'],
        'CSRFName' => 'CSRFGuard_29712765',
        'CSRFToken' => '826652f6997e742a98af37540a8fef288262b2a599c1e36309955883cb22150f748ce7b58969f5b16b7c06761ac737dbb852512535f37797169a493fd5ba4a47',
        'reqURI' => '',
        'destination' => ''
    );
    
    // Usar cURL para hacer POST al login real
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost:8080/login.php?viewer=');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($login_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // No seguir redirecciones
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $info = curl_getinfo($ch);
    curl_close($ch);
    
    echo "<h3>Respuesta del servidor:</h3>";
    echo "<p><strong>Código HTTP:</strong> $httpCode</p>";
    
    if ($httpCode == 302) {
        echo "<p style='color:green'>✅ Redirección detectada (login exitoso)</p>";
        if (isset($info['redirect_url'])) {
            echo "<p><strong>Redirigiendo a:</strong> " . $info['redirect_url'] . "</p>";
        }
    } else {
        echo "<p style='color:red'>❌ Sin redirección (login falló)</p>";
    }
    
    // Separar headers y body
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($response, 0, $header_size);
    $body = substr($response, $header_size);
    
    echo "<h3>Headers de respuesta:</h3>";
    echo "<pre>" . htmlspecialchars($headers) . "</pre>";
    
    echo "<h3>Información de cURL:</h3>";
    echo "<pre>";
    print_r($info);
    echo "</pre>";
    
    // Buscar redirección en headers
    if (preg_match('/Location: (.+)/', $headers, $matches)) {
        $location = trim($matches[1]);
        echo "<p style='color:green'>✅ <strong>Redirección encontrada:</strong> $location</p>";
        
        // Seguir la redirección manualmente
        echo "<h3>Siguiendo redirección...</h3>";
        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, $location);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_COOKIEFILE, 'cookies.txt');
        curl_setopt($ch2, CURLOPT_HEADER, true);
        
        $response2 = curl_exec($ch2);
        $httpCode2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
        curl_close($ch2);
        
        echo "<p><strong>Código de la página final:</strong> $httpCode2</p>";
        
        if ($httpCode2 == 200) {
            echo "<p style='color:green'>✅ Página final cargada correctamente</p>";
        } else {
            echo "<p style='color:red'>❌ Error en página final</p>";
        }
    }
    
    echo "<h3>Contenido de respuesta (primeros 1000 caracteres):</h3>";
    echo "<pre>" . htmlspecialchars(substr($body, 0, 1000)) . "</pre>";
}

?>

<h2>Test POST al login real</h2>
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
        <input type="submit" value="Test Login Real" style="padding:10px; background:#dc3545; color:white; border:none;">
    </p>
</form>