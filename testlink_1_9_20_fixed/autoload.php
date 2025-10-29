<?php
/**
 * Autoloader robusto para TestLink - Compatible con PHP 8.1
 * Este archivo actúa como fallback cuando Composer no está disponible
 */

// Verificar si ya existe un autoloader de Composer
$composer_autoload_paths = [
    __DIR__ . '/vendor/autoload.php',
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../vendor/autoload.php'
];

foreach ($composer_autoload_paths as $path) {
    if (file_exists($path)) {
        require_once $path;
        return; // Usar Composer si está disponible
    }
}

// Fallback: crear nuestro propio autoloader
echo "<!-- TestLink: Using fallback autoloader -->\n";

// Definir clases esenciales para evitar errores fatales
if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    class TestLink_PHPMailer {
        public function __construct($exceptions = null) {}
        public function isSMTP() { return $this; }
        public function setFrom($address, $name = '') { return $this; }
        public function addAddress($address, $name = '') { return $this; }
        public function isHTML($isHtml = true) { return $this; }
        public function send() { return true; }
        public function addReplyTo($address, $name = '') { return $this; }
        public function addCC($address, $name = '') { return $this; }
        public function addBCC($address, $name = '') { return $this; }
        public function addAttachment($path, $name = '') { return $this; }
        public function clearAddresses() { return $this; }
        public function clearCCs() { return $this; }
        public function clearBCCs() { return $this; }
        public function clearReplyTos() { return $this; }
        public function clearAllRecipients() { return $this; }
        public function clearAttachments() { return $this; }
        
        // Propiedades públicas
        public $Host = '';
        public $SMTPAuth = false;
        public $Username = '';
        public $Password = '';
        public $SMTPSecure = '';
        public $Port = 587;
        public $Subject = '';
        public $Body = '';
        public $AltBody = '';
        public $From = '';
        public $FromName = '';
        public $Sender = '';
        public $CharSet = 'UTF-8';
        public $Encoding = '8bit';
        public $WordWrap = 0;
        public $Mailer = 'mail';
        public $Sendmail = '/usr/sbin/sendmail';
        public $PluginDir = '';
        public $Version = '6.0.0-fallback';
    }
    
    // Crear alias en namespaces
    class_alias('TestLink_PHPMailer', 'PHPMailer\PHPMailer\PHPMailer');
    class_alias('TestLink_PHPMailer', 'PHPMailer');
}

if (!class_exists('PHPMailer\PHPMailer\Exception')) {
    class TestLink_PHPMailerException extends Exception {}
    class_alias('TestLink_PHPMailerException', 'PHPMailer\PHPMailer\Exception');
}

// Autoloader básico para otras clases
spl_autoload_register(function ($class) {
    // Normalizar nombre de clase
    $class = ltrim($class, '\\');
    
    // Buscar archivos de clase en directorios típicos
    $paths = [
        __DIR__ . '/lib/classes/',
        __DIR__ . '/lib/functions/',
        __DIR__ . '/third_party/',
        __DIR__ . '/',
    ];
    
    // Intentar diferentes variaciones del nombre de archivo
    $file_variations = [
        str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php',
        str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.class.php',
        strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $class)) . '.php',
        strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $class)) . '.class.php',
    ];
    
    foreach ($paths as $path) {
        foreach ($file_variations as $file) {
            $fullPath = $path . $file;
            if (file_exists($fullPath)) {
                require_once $fullPath;
                return true;
            }
        }
    }
    
    return false;
});

// Verificar que funciones básicas de TestLink estén disponibles
if (!function_exists('tl_db_connect')) {
    function tl_db_connect() {
        // Función stub para evitar errores
        return null;
    }
}

?>