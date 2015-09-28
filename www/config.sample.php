<?php 
/**
* configuration file
*/

error_reporting(E_ERROR | E_WARNING | E_PARSE);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', realpath($_SERVER['DOCUMENT_ROOT']) . DS);
define('CORE_DIR', realpath($_SERVER['DOCUMENT_ROOT']) . DS . 'core' . DS);
define('SITE_DIR', 'http://' . str_replace('http://', '', $_SERVER['HTTP_HOST'] . '/'));
define('TEMPLATE_DIR', ROOT_DIR . 'templates' . DS);
define('FR_ROOT_DIR', 'path/to/filerun_root' . DS);
define('IMAGE_DIR', ROOT_DIR . 'agsdocs' . DS . 'images' . DS);
define('LIBS_DIR', ROOT_DIR . 'libs' . DS);

define('DB_NAME', 'agstrad_bd');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

define('FR_URL', 'https://filerun.froginnov.com/');
define('FR_CLIENT_ID', 'e2d4b87964837e2c3c69e8a07af3153c');
define('FR_CLIENT_SECRET', '6KnIkFzXQtOqZmrAAD5p0pM0Rox7Kq7qLuUYH2r3');

define('FR_ORDER_USER', 'wIHPzR3&7DGU');
define('API_SECRET', 'Uw$jXwjxuZ');
