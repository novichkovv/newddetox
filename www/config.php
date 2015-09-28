<?php 
/**
* configuration file
*/

error_reporting(E_ERROR | E_WARNING | E_PARSE);
define('DS', DIRECTORY_SEPARATOR);
if(null !== ROOT_DIR) {
    define('ROOT_DIR', realpath($_SERVER['DOCUMENT_ROOT']) . DS);
}

define('CORE_DIR', ROOT_DIR . 'core' . DS);
define('SITE_DIR', 'http://' . str_replace('http://', '', $_SERVER['HTTP_HOST'] . '/'));
define('TEMPLATE_DIR', ROOT_DIR . 'templates' . DS);
define('IMAGE_DIR', ROOT_DIR . 'agsdocs' . DS . 'images' . DS);
define('LIBS_DIR', ROOT_DIR . 'libs' . DS);

define('DB_NAME', 'ddetox');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

