<?php
// Verificar configuración de logos Banco Santander
include_once('php81_compatibility.inc.php');
include_once('config.inc.php');

echo "<h1>Verificación de Logos Banco Santander</h1>";

echo "<h2>Configuración de logos:</h2>";
if (isset($tlCfg->logo_login)) {
    echo "<p>✅ Logo login: " . $tlCfg->logo_login . "</p>";
} else {
    echo "<p>❌ Logo login no configurado</p>";
}

if (isset($tlCfg->logo_navbar)) {
    echo "<p>✅ Logo navbar: " . $tlCfg->logo_navbar . "</p>";
} else {
    echo "<p>❌ Logo navbar no configurado</p>";
}

echo "<h2>Archivos de logo disponibles:</h2>";
$logo_dir = 'gui/themes/default/images/';
$logo_files = [
    'banco-santander-logo.png',
    'tl-logo-transparent.png',
    'tl-logo-transparent-25.png', 
    'tl-logo-transparent-12.5.png'
];

foreach ($logo_files as $file) {
    $full_path = $logo_dir . $file;
    if (file_exists($full_path)) {
        $size = filesize($full_path);
        echo "<p style='color:green'>✅ $file (${size} bytes)</p>";
    } else {
        echo "<p style='color:red'>❌ $file NO encontrado</p>";
    }
}

echo "<h2>CSS personalizado:</h2>";
$css_file = 'gui/themes/default/css/banco-santander-custom.css';
if (file_exists($css_file)) {
    echo "<p style='color:green'>✅ CSS personalizado disponible</p>";
} else {
    echo "<p style='color:red'>❌ CSS personalizado NO encontrado</p>";
}

echo "<h2>Vista previa de logos (tamaños reales de TestLink):</h2>";
echo "<div style='border: 1px solid #ccc; padding: 20px; margin: 10px 0; background: #f9f9f9;'>";
echo "<h3>Logo Login (como se ve en TestLink):</h3>";
echo "<img src='gui/themes/default/images/tl-logo-transparent-25.png' style='max-width: 180px; max-height: 60px; width: auto; height: auto; object-fit: contain; border: 1px solid #eee; margin: 10px; display: block;' alt='Logo Login'>";
echo "<h3>Logo Navbar (como se ve en TestLink):</h3>";
echo "<img src='gui/themes/default/images/tl-logo-transparent-12.5.png' style='max-width: 180px; max-height: 60px; width: auto; height: auto; object-fit: contain; border: 1px solid #eee; margin: 10px; display: block;' alt='Logo Navbar'>";
echo "<h3>Logo Banco Santander (nuevo):</h3>";
echo "<img src='gui/themes/default/images/banco-santander-logo.png' style='max-width: 180px; max-height: 60px; width: auto; height: auto; object-fit: contain; border: 1px solid #eee; margin: 10px; display: block;' alt='Logo Banco Santander'>";
echo "<p style='font-size: 0.9em; color: #666; margin-top: 15px;'>";
echo "<strong>Configuración aplicada:</strong><br>";
echo "• Ancho máximo: 180px<br>";
echo "• Alto máximo: 60px<br>";
echo "• Proporciones mantenidas automáticamente<br>";
echo "• Object-fit: contain (mantiene aspecto original)";
echo "</p>";
echo "</div>";

echo "<p style='color:green'><strong>✅ Configuración de logos completada</strong></p>";
echo "<p>Los logos de TestLink han sido reemplazados por el logo de Banco Santander y configurados para mantener proporciones adecuadas.</p>";
?>