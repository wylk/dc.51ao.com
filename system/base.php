<?php
/**
 *      [Haidao] (C)2013-2099 Dmibox Science and technology co., LTD.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      http://www.haidao.la
 *      tel:400-600-2042
 */
define('IN_APP', true);
defined('APP_ROOT') 	OR 		define('APP_ROOT', str_replace("\\","/",substr(dirname(__FILE__), 0, -6)));
defined('LIB_PATH') 	OR 		define('LIB_PATH',  APP_PATH.'library/');
defined('CORE_PATH') 	OR 		define('CORE_PATH',  APP_PATH.'core/');
defined('CONF_PATH')    OR 		define('CONF_PATH',  DOC_ROOT.'config/');
defined('CACHE_PATH') 	OR 		define('CACHE_PATH',  DOC_ROOT.'caches/');
defined('TPL_PATH') 	OR 		define('TPL_PATH',  DOC_ROOT.'template/');
defined('LANG_PATH') 	OR 		define('LANG_PATH',  APP_PATH.'language/');

defined('APP_DEBUG') 	OR 		define('APP_DEBUG', false);
/* Èë¿ÚÎÄ¼þ */
defined('__APP__') 	    OR 		define('__APP__', $_SERVER['SCRIPT_NAME']);
/* °²×°Ä¿Â¼ */
define('__ROOT__', str_replace(basename(__APP__), "", __APP__));
/* ²å¼þÄ¿Â¼ */
defined('PLUGIN_PATH') 	OR 		define('PLUGIN_PATH',  APP_PATH.'plugin/');

define('IS_CGI',(0 === strpos(PHP_SAPI,'cgi') || false !== strpos(PHP_SAPI,'fcgi')) ? 1 : 0 );
define('IS_WIN',strstr(PHP_OS, 'WIN') ? 1 : 0 );
define('IS_CLI',PHP_SAPI=='cli'? 1   :   0);
define('EXT', '.class.php');
define('FOOD_PATH','./system/plugin/food/template/static/');
define('FOOD_PATH_HTML','./system/plugin/food/template/admin/');
define('UPLOAD_PATH','./system/library/');
define('DISPLAY_PATH', PLUGIN_PATH.'food/template/');
require CORE_PATH.'hd_core'.EXT;
// require CORE_PATH.'hd_load'.EXT;
require APP_PATH.'function/function.php';

set_exception_handler(array('C', 'handleException'));
set_error_handler(array('C', 'handleError'));
register_shutdown_function(array('C', 'handleShutdown'));

if(function_exists('spl_autoload_register')) {
	spl_autoload_register(array('C', 'autoload'));
} else {
	function __autoload($class) {
		return C::autoload($class);
	}
}
C::run();
function dump($var, $echo = true, $label = null, $strict = true)
{
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    } else
        return $output;
}

