<?php 
/**
 * 
 */

class Controller 
{
	public function model($model)
	{
		if (file_exists('app'.DS.'models'.DS.$model.'.php')) {
			return new $model();
		} else {
			die('Model '.$model.' not exist.');
		}
	}

	public function view($view,$data = [])
	{
		$init_view = new View();
		return $init_view->render($view,$data);
	}

	public function JsonResponse ($data = '')
    {
        echo json_encode($data);
    }
}
 ?>