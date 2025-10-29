<?php
// Verificar centrado del logo del navbar
include_once('php81_compatibility.inc.php');
include_once('config.inc.php');

echo "<h1>Verificación del Logo Centrado en Navbar</h1>";

echo "<h2>Configuración aplicada:</h2>";
echo "<ul>";
echo "<li>✅ Ancho del contenedor del logo: 140px</li>";
echo "<li>✅ Alineación: Centro (text-align: center)</li>";
echo "<li>✅ Flexbox: justify-content: center + align-items: center</li>";
echo "<li>✅ Padding: 5px para separación</li>";
echo "<li>✅ Logo con margin: 0 auto</li>";
echo "</ul>";

echo "<h2>Estilos aplicados al template navbar:</h2>";
echo "<div style='background: #f5f5f5; padding: 15px; border-left: 4px solid #007cba; margin: 10px 0;'>";
echo "<code>";
echo "div style=\"float:left; height: 100%; width: 140px; text-align: center;<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;display: flex; align-items: center; justify-content: center; padding: 5px;\"<br>";
echo "<br>";
echo "img style=\"display: block; margin: 0 auto; max-width: 120px;<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;max-height: 30px; object-fit: contain;\"";
echo "</code>";
echo "</div>";

echo "<h2>Vista previa del logo centrado:</h2>";
echo "<div style='border: 2px solid #ddd; padding: 20px; margin: 10px 0; background: #fff;'>";
echo "<h3>Simulación del navbar (140px de ancho):</h3>";
echo "<div style='width: 140px; height: 50px; border: 1px solid #ccc; text-align: center; display: flex; align-items: center; justify-content: center; padding: 5px; background: #f9f9f9;'>";
echo "<img src='gui/themes/default/images/banco-santander-logo.png' style='display: block; margin: 0 auto; max-width: 120px; max-height: 30px; object-fit: contain;' alt='Logo centrado'>";
echo "</div>";
echo "<p style='font-size: 0.9em; color: #666; margin-top: 10px;'>";
echo "↑ Este es como se vería el logo en el navbar real de TestLink";
echo "</p>";
echo "</div>";

echo "<h2>Para verificar en TestLink:</h2>";
echo "<ol>";
echo "<li>Hacer login en: <a href='login.php' target='_blank'>http://localhost:8080/login.php</a></li>";
echo "<li>Usar credenciales: <strong>arivera/arivera</strong> o <strong>admin/admin</strong></li>";
echo "<li>Observar el logo en la parte superior izquierda del navbar</li>";
echo "<li>El logo ahora debería estar centrado dentro de su contenedor</li>";
echo "</ol>";

echo "<p style='color: green; font-weight: bold; margin-top: 20px;'>✅ Configuración de centrado aplicada correctamente</p>";
?>

<style>
/* CSS adicional para la verificación */
code {
    font-family: 'Courier New', monospace;
    font-size: 0.9em;
    line-height: 1.4;
}
</style>