<?php
	// load file config 
	require_once (ROOT.DS.'app'.DS.'config'.DS.'config.php');
	// load file config 
	require_once (ROOT.DS.'app'.DS.'lib'.DS.'helpers'.DS.'functions.php');

	// get url variable in file htaccess url=$1
	$url = isset($_GET['url'])?explode('/',filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL)):[];
	function autoload($className)
	{
		if (file_exists(ROOT.DS.'app'.DS.'core'.DS.$className.'.php')) {
			require_once (ROOT.DS.'app'.DS.'core'.DS.$className.'.php');
		} elseif (file_exists(ROOT.DS.'app'.DS.'controller'.DS.$className.'.php')) {
			require_once (ROOT.DS.'app'.DS.'controller'.DS.$className.'.php');
		} elseif (file_exists(ROOT.DS.'app'.DS.'models'.DS.$className.'.php')) {
			require_once (ROOT.DS.'app'.DS.'models'.DS.$className.'.php');
		} else {
			die('The class'.$className.' not exist');
		}
	}	
	spl_autoload_register ('autoload');
	session_start();
	Router::route($url);
?>