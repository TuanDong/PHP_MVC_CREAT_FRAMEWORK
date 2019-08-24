<?php
/**
  * 
  */
class Home extends Controller
{
 	public function index()
 	{
 		// $db = DB::getInstance();
 		// $resutl = $db->insert('table_connect',['','Iphone','Iphone connect',1]);
		// $resutl = $db->update('table_connect',[7,'pc computer']);
		// $resutl = $db->findFirst('table_connect',[
		// 	'conditions'=>['name = ?'],
		// 	'bind'=>['Iphone'],
		// 	'order'=>'id',
		// 	'limit' => 3
		// ]);
 		// var_dump($resutl);
		// $user = $this->model('User');
		// $Sales = $this->model('Sales');
		// $resutl = $Sales->findByID(4);
		// var_dump($resutl);
 		$this->view('home/index',[['fistName'=>'John','lastName'=>'Doe','Email'=>'john@example.com'],['fistName'=>'Mary','lastName'=>'Moe','Email'=>'Mary@example.com'],['fistName'=>'July','lastName'=>'Dooley','Email'=>'July@example.com']]);
 	}	
 	public function test()
 	{
 		$db = DB::getInstance();
 		$resutl = $db->insert('table_connect',['name'=>'Iphone','description'=>'Iphone connect','number'=>1]);
 	}
} 
?>