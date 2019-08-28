<?php

class Model
{
    protected $_db, $table, $_modelName,$_columnName=[];
    public $id;
    public function __construct() {
        $this->_modelName = isset($this->class)?$this->_modelName : get_class($this);
        $this->_db = DB::getInstance();
        $this->_setTableColumns();
    }

    protected function _setTableColumns() {
        $columns = $this->_db->get_columns($this->table);
        foreach ($columns as $column) {
            $this->_columnName[] = $column->Field;
        }
    }

    public function find($params) {
        $results = [];
        $resultsQuery = $this->_db->find($this->table,$params);
        foreach ($resultsQuery as $resutl) {
           $obj = new class{};
           foreach ($resutl as $key => $value) {
               $obj->$key = $value;
           }
           $results[] = $obj;
        }
        return $results;
    }
    public function findFirst($params) {
        $resultsQuery = $this->_db->findFirst($this->table,$params);
        return $resultsQuery;
    }
    public function findByID($id) {
        $primary_key = $this->_db->get_key($this->table);
        $resultsQuery = $this->findFirst($this->table,['conditions'=>[$primary_key.' = ?'],'bind' =>[$id]]);
        return $resultsQuery;
    }

    public function insert($allFiled)
    {
        if (empty($allFiled)) return false;
        return $this->_db->insert($this->table,$allFiled);
    }

    public function delete($id='')
    {
        if ($id == '' || $this->id == '') return false;
        $id = ($id == '')? $this->id:$id;
        return $this->_db->delete($this->table,$id);
    }

    public function update($id,$filed)
    {
        if ($id == '' ||empty( $filed)) return false;
        return $this->_db->update($this->table,$id,$filed);
    }
    
    public function query($sql,$bind=[])
    {
        $results = [];
        $results = $this->_db->query($sql,$bind);
        if ( ! $results->error()) {
            return $results->results();
        }
        return $results;
    }

    public function save()
    {       
        $filed = [];
        foreach ($this->_columnName as $column) {
            $filed[$column] = $this->$column;
        }
        if (property_exists($this,'id') && $this->id != '') {
            return $this->update($this->id,$filed);
        } else {
            return $this->insert($filed);
        }
    }
	public function get_all()
    {
        $results = [];
        $sql = "SELECT * FROM {$this->table}";
        $results = $this->_db->query($sql);
        if ( ! $results->error()) {
            return $results->results();
        }
        return $results;
    }
}
