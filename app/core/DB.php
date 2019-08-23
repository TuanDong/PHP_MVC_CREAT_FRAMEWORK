<?php 
/**
 * 
 */
class DB
{
	private static $_intance = null;
	private $_pdo,$_query,$_result,$_count = 0, $_lastInsertID = null,$_error = false;
	private function __construct()
	{
		try {
			$this->_pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',DB_USERNAME,DB_PASSWORD);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
	public static function getInstance()
	{
		if (!isset(self::$_intance)) {
			self::$_intance = new DB();
		}
		return self::$_intance;
	}
	public function query($sql,$params = [])
	{
		$this->_error = false;
		if ($this->_query = $this->_pdo->prepare($sql)) {
			$stt = 1;
			foreach ($params as $param) {
				$this->_query->bindValue($stt,$param);
				$stt ++;
			}
		}
		if ($this->_query->execute()) {
			$this->_result = $this->_query->fetchAll(PDO::FETCH_CLASS);
			$this->_count = $this->_query->rowCount();
			$this->_lastInsertID = $this->_pdo->lastInsertId();
		}else {
			$this->_error = true;
		}
		return $this;
	}
	public function insert($table,$params)
	{
		if(isset($params) && empty($params))
		{
			return false;
		}
		$fieldString = '';
		$valueString = '';
		$values = [];
		// $sql_filedTable = "SHOW COLUMNS FROM {$table}";
		// $array_filedTable = $this->query($sql_filedTable)->_result;
		// if (is_array($array_filedTable) && count($array_filedTable)== 0) {
		// 	return false;
		// }
		// foreach ($array_filedTable as $key => $value) {
		// 	$fieldString .='`'.$value->Field.'`,';
		// }
		foreach ($params as $key => $value) 
		{
			$fieldString .='`'.$key.'`,';
			$valueString .='?,';
			$values[] = $value;
		}
		$fieldString = rtrim($fieldString,',');
		$valueString = rtrim($valueString,',');
		$sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";
		if (!$this->query($sql,$values)->_error) {
			return true;
		}
		return false;
	}
	public function update($table,$id,$params)
	{
		if((isset($params) && empty($params)|| empty($id)))
		{
			return false;
		}
		$fieldString = '';
		$sql = "SHOW KEYS FROM {$table} WHERE Key_name = 'PRIMARY'";
		$primary_key = $this->query($sql)->_result[0]->Column_name;
		if (is_array($primary_key) && count($primary_key)== 0) {
			return false;
		}
		foreach ($params as $key => $value) {
			$fieldString .="`".$key."` = '".$value."',";
		}
		$fieldString = rtrim($fieldString,',');
		$sql = "UPDATE `{$table}` SET {$fieldString} WHERE {$primary_key} = {$id}";
		if (!$this->query($sql)->_error) {
			return true;
		}
		return false;	
	}
	public function delete($table,$id)
	{
		$sql = "SHOW KEYS FROM {$table} WHERE Key_name = 'PRIMARY'";
		$primary_key = $this->query($sql)->_result[0]->Column_name;
		if (is_array($primary_key) && count($primary_key)== 0) {
			return false;
		}
		$sql = "DELETE FROM `{$table}` WHERE {$primary_key} = {$id}";
		if (!$this->query($sql)->_error) {
			return true;
		}
		return false;
	}
	
	public function results()
	{
		return $this->_result;
	}

	public function first()
	{
		return (!empty($this->_result))? $this->_result[0]:[];
	}

	public function count()
	{
		return $this->_count;
	}
	public function lastID()
	{
		return $this->_lastInsertID;
	}

	public function get_columns($table)
	{
		return $this->query("SHOW COLUMNS FROM {$table}")->results();
	}
	
	public function get_key($table)
	{
		$primary_key = '';
		$sql = "SHOW KEYS FROM {$table} WHERE Key_name = 'PRIMARY'";
		$primary_key = $this->query($sql)->_result[0]->Column_name;
		return $primary_key;
	}
	protected function _read($table, $params=[])
	{
		$conditionString = '';
		$bind =[];
		$order ='';
		$limit = '';
		// conditions
		if (isset($params['conditions'])) {
			if (is_array($params['conditions'])) {
				foreach ($params['conditions'] as $condition) {
					$conditionString .=' '. $condition.' AND';
				}
				$conditionString = trim($conditionString);
				$conditionString = rtrim($conditionString, ' AND');
			}else {
				$conditionString = $params['conditions'];
			}
			if ($conditionString != '') {
				$conditionString = ' WHERE '. $conditionString;
			}
		}
		// bind
		if (array_key_exists('bind',$params)) {
			$bind = $params['bind'];	
		}
		// order
		if (array_key_exists('order',$params)) {
			$order = ' ORDER BY '. $params['order'];	
		}
		// limit
		if (array_key_exists('limit',$params)) {
			$order = ' LIMIT '. $params['limit'];	
		}
		$sql = "SELECT * FROM {$table}{$conditionString}{$order}{$limit}";
		if ($this->query($sql,$bind)) {
			if (!count($this->_result)) return false;
			return true;
		}
		return false;
	}
	public function find($table,$params=[])
	{
		if ($this->_read($table,$params)) {
			return $this->results();
		}
		return false;
	}

	public function findFirst($table,$params =[])
	{
		if ($this->_read($table,$params)) {
			return $this->first();
		}
		return false;
	}
	public function error()
	{
		return $this->_error;
	}
}
 ?>