<?php
// Configuración simplificada para Railway - solo mostrar página
echo "<!DOCTYPE html>
<html>
<head>
    <title>TestLink SCB - Aseguramiento de Calidad</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .logo { max-width: 200px; margin: 20px auto; display: block; }
        .success { color: #28a745; font-size: 24px; margin: 20px 0; }
        .info { color: #17a2b8; margin: 10px 0; }
    </style>
</head>
<body>
    <img src='custom/images/Banco_Santander.png' alt='Banco Santander' class='logo'>
    <h1>TestLink - Aseguramiento de Calidad SCB</h1>
    <div class='success'>✅ Aplicación Desplegada Exitosamente</div>
    <div class='info'>🚀 PHP " . PHP_VERSION . " funcionando correctamente</div>
    <div class='info'>🌐 Servidor: " . ($_SERVER['HTTP_HOST'] ?? 'Railway') . "</div>
    <div class='info'>📅 " . date('Y-m-d H:i:s') . "</div>
    <p><strong>Próximos pasos:</strong> Configurar base de datos para funcionalidad completa</p>
</body>
</html>";
?>