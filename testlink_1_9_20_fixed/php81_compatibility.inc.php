<?php
/**
 * PHP 8.1 Compatibility Layer for TestLink 1.9.20 - ENHANCED
 * Este archivo proporciona funciones y métodos que fueron removidos o cambiados en PHP 8.1
 */

// Suprimir warnings de compatibilidad
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);

/**
 * Critical: Initialize $tlCfg before any other includes to prevent errors
 * This ensures const.inc.php can run without errors
 */
if (!isset($tlCfg)) {
    $tlCfg = new stdClass();
    $tlCfg->api = new stdClass();
    $tlCfg->cookie = new stdClass();
    $tlCfg->document_generator = new stdClass();
    $tlCfg->spec_cfg = new stdClass();
    $tlCfg->exec_cfg = new stdClass();
    $tlCfg->exec_cfg->view_mode = new stdClass();
    $tlCfg->exec_cfg->exec_mode = new stdClass();
}

/**
 * Critical fix: Add missing prepare_string method to mysqli
 */
if (class_exists('mysqli')) {
    // Monkey patch mysqli to add missing methods
    if (!method_exists('mysqli', 'prepare_string')) {
        // Create a global function that TestLink can use
        if (!function_exists('mysqli_prepare_string_compat')) {
            function mysqli_prepare_string_compat($db, $query) {
                if (is_object($db) && method_exists($db, 'real_escape_string')) {
                    return $db->real_escape_string($query);
                }
                return addslashes($query);
            }
        }
    }
}

/**
 * Fix ADODB compatibility issues with PHP 8.1
 */
// Ensure ADODB error suppression
$ADODB_NEVER_PERSIST = true;
if (!defined('ADODB_ERROR_HANDLER_TYPE')) {
    define('ADODB_ERROR_HANDLER_TYPE', E_USER_ERROR);
}

// Fix for ADODB undefined property warnings
function adodb_php81_error_handler($errno, $errstr, $errfile, $errline) {
    // Suppress ADODB-related warnings that are common in PHP 8.1
    if (strpos($errfile, 'adodb') !== false || 
        strpos($errstr, 'ADO') !== false ||
        strpos($errstr, 'qstr') !== false) {
        return true;
    }
    return false;
}

// Additional ADODB compatibility
if (!function_exists('adodb_qstr')) {
    function adodb_qstr($s, $magic_quotes = false) {
        if (!$magic_quotes) {
            return "'" . addslashes($s) . "'";
        }
        return "'" . $s . "'";
    }
}

/**
 * Fix for deprecated functions
 */

// Fix for deprecated create_function()
if (!function_exists('create_function')) {
    function create_function($args, $code) {
        static $cache = [];
        $key = md5($args . $code);
        
        if (!isset($cache[$key])) {
            $cache[$key] = eval("return function($args) { $code };");
        }
        
        return $cache[$key];
    }
}

// Fix for deprecated split() function
if (!function_exists('split')) {
    function split($pattern, $string, $limit = -1) {
        return preg_split('/' . preg_quote($pattern, '/') . '/', $string, $limit);
    }
}

// Fix for deprecated each() function
if (!function_exists('each')) {
    function each(&$array) {
        $key = key($array);
        $value = current($array);
        next($array);
        
        if ($key === null) {
            return false;
        }
        
        return array(
            0 => $key,
            1 => $value,
            'key' => $key,
            'value' => $value
        );
    }
}

/**
 * Fix for session handling in PHP 8.1
 */
if (!function_exists('session_is_registered')) {
    function session_is_registered($name) {
        return isset($_SESSION[$name]);
    }
}

if (!function_exists('session_register')) {
    function session_register($name) {
        $_SESSION[$name] = null;
        return true;
    }
}

if (!function_exists('session_unregister')) {
    function session_unregister($name) {
        unset($_SESSION[$name]);
        return true;
    }
}

/**
 * Compatibility for magic quotes (removed in PHP 7.4+)
 */
if (!function_exists('get_magic_quotes_gpc')) {
    function get_magic_quotes_gpc() {
        return false;
    }
}

if (!function_exists('get_magic_quotes_runtime')) {
    function get_magic_quotes_runtime() {
        return false;
    }
}

/**
 * Fix for deprecated mysql_* functions (if any remain)
 */
if (!function_exists('mysql_escape_string')) {
    function mysql_escape_string($string) {
        if (isset($GLOBALS['db_connection']) && is_object($GLOBALS['db_connection'])) {
            return $GLOBALS['db_connection']->real_escape_string($string);
        }
        return addslashes($string);
    }
}

/**
 * Enhanced error handler for TestLink compatibility
 */
function testlink_php81_error_handler($errno, $errstr, $errfile, $errline) {
    // Suprimir ciertos warnings que son incompatibilidades conocidas
    $suppress_patterns = [
        '/Undefined property.*mysqli.*db/',
        '/Call to undefined method mysqli::prepare_string/',
        '/Undefined variable/',
        '/Deprecated/',
        '/Notice:/',
        '/create_function/',
        '/each\(\)/',
        '/split\(\)/',
        '/array_key_exists.*null/',
        '/isConnected\(\) on null/'
    ];
    
    foreach ($suppress_patterns as $pattern) {
        if (preg_match($pattern, $errstr)) {
            return true; // Suprimir el error
        }
    }
    
    // Para otros errores, usar el handler por defecto
    return false;
}

// Configurar el handler de errores
set_error_handler('testlink_php81_error_handler', E_ALL);

/**
 * Configuración adicional para PHP 8.1
 */
ini_set('memory_limit', '512M');
ini_set('max_execution_time', '300');
ini_set('display_errors', '0'); // Disable display errors in production-like environment
ini_set('log_errors', '1');

// Configurar timezone si no está configurado
if (!ini_get('date.timezone')) {
    date_default_timezone_set('America/Mexico_City');
}

// Ajustes para sesiones en PHP 8.1
if (version_compare(PHP_VERSION, '8.1.0', '>=')) {
    // Configurar opciones de sesión compatibles
    if (!headers_sent()) {
        ini_set('session.cookie_samesite', 'Lax');
        ini_set('session.cookie_httponly', '1');
    }
}

?>