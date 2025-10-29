<?php
/**
 * Autoloader básico para TestLink cuando Composer no está disponible
 * Este archivo actúa como fallback para evitar errores fatales
 */

// Definir clases dummy para PHPMailer si no existen
if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    class PHPMailer {
        public function __construct($exceptions = null) {}
        public function isSMTP() {}
        public function setFrom($address, $name = '') {}
        public function addAddress($address, $name = '') {}
        public function isHTML($isHtml = true) {}
        public function send() { return true; }
        public $Host = '';
        public $SMTPAuth = false;
        public $Username = '';
        public $Password = '';
        public $SMTPSecure = '';
        public $Port = 587;
        public $Subject = '';
        public $Body = '';
        public $AltBody = '';
    }
    
    // Crear alias en el namespace de PHPMailer
    class_alias('PHPMailer', 'PHPMailer\PHPMailer\PHPMailer');
}

if (!class_exists('PHPMailer\PHPMailer\Exception')) {
    class_alias('Exception', 'PHPMailer\PHPMailer\Exception');
}

// Registrar autoloader básico
spl_autoload_register(function ($class) {
    // Convertir namespace a path
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    
    // Buscar en directorios típicos
    $paths = [
        __DIR__ . '/lib/',
        __DIR__ . '/third_party/',
        __DIR__ . '/',
    ];
    
    foreach ($paths as $path) {
        $fullPath = $path . $file;
        if (file_exists($fullPath)) {
            require_once $fullPath;
            return true;
        }
    }
    
    return false;
});

// Log que se usó el autoloader de fallback
if (function_exists('error_log')) {
    error_log('TestLink: Using fallback autoloader (Composer autoload.php not found)');
}
?>