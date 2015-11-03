<?php

// Configuration
define('DEBUG', true);
define('PROD', false);

// Security
define('AUTH_ENABLE', true);
define('SALT',   'salt');
define('PEPPER', 'pepper');

// Global
define('WEBROOT', dirname(__FILE__));
define('ROOT', dirname(WEBROOT));
define('DS', DIRECTORY_SEPARATOR);
define('BASE_URL', dirname(dirname($_SERVER['SCRIPT_NAME'])) == '/' ? '' : dirname(dirname($_SERVER['SCRIPT_NAME'])));
define('HOSTNAME', $_SERVER['HTTP_HOST']);

define('CORE', ROOT.DS.'Core'.DS);
define('CONTROLLERS', ROOT.DS.'Controllers'.DS);
define('VIEWS', ROOT.DS.'Views'.DS);
define('ELEMENTS', VIEWS.'Elements'.DS);
define('MODELS', ROOT.DS.'Models'.DS);

define('CSS', BASE_URL.DS.'css'.DS);
define('JS', BASE_URL.DS.'js'.DS);
define('IMG', BASE_URL.DS.'img'.DS);
define('FONTS', BASE_URL.DS.'fonts'.DS);
define('FILES', BASE_URL.DS.'files'.DS);

define('CSS_ROOT', ROOT.DS.'webroot'.DS.'css'.DS);
define('JS_ROOT', ROOT.DS.'webroot'.DS.'js'.DS);
define('IMG_ROOT', ROOT.DS.'webroot'.DS.'img'.DS);
define('FONTS_ROOT', ROOT.DS.'webroot'.DS.'fonts'.DS);
define('FILES_ROOT', ROOT.DS.'webroot'.DS.'files'.DS);

// Database
class DBConfig
{
	public static $databases = array(
		'dev' => array(
			'dbtype'	=> 'mysql',
			'host'		=> '[[DB_HOST]]',
			'database'	=> '[[DB_NAME]]',
			'login'		=> '[[DB_LOGIN]]',
			'password'	=> '[[DB_PASS]]',
			'prefix'	=> '',
			'encoding'	=>	'utf8'
		),
		'prod' => array(
			'dbtype'	=> 'mysql',
			'host'		=> '[[DB_HOST]]',
			'database'	=> '[[DB_NAME]]',
			'login'		=> '[[DB_LOGIN]]',
			'password'	=> '[[DB_PASS]]',
			'prefix'	=> '',
			'encoding'	=>	'utf8'
		)
	);
}

?>