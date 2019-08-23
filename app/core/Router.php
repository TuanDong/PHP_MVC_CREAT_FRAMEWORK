<?php 
/**
 * 
 */
class Router 
{
	public static function route($url)
	{
		//controller
		$controller = (isset($url[0]) && $url[0] != '') ? $url[0] : DEFAULT_CONTROLLER;
		array_shift($url);

		//action
		$action = (isset($url[0]) && $url[0] != '') ? $url[0] : 'index';
		array_shift($url);

		//params
		$params = array_values($url);

		$controller = new $controller();
		if (method_exists($controller, $action)) {
			call_user_func_array([$controller,$action], $params);
		} else {
			die('The action not exist');
		}
		
	}
}