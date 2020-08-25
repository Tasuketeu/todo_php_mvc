<?php

	// FRONT CONTROLLER

	//general settings
	ini_set('display_errors',1);
	error_reporting(E_ALL);

	session_start();

	//connect system files 
	define('ROOT',dirname(__FILE__));

	spl_autoload_register(function ($class_name) {
			$array_paths = array(
		'components/',
		'models/',
			);

			foreach ($array_paths as $path) {
				$path = './includes/'. $path . $class_name.'.php'; 
				if(is_file($path)){
					include_once $path;
				}
			}
	});
	//Call Router
	$router = new Router();
	$router->run();

?>

