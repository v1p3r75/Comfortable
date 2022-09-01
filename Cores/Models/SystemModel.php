<?php

namespace System\Models;

use System\Database\Database;
use System\Exceptions\ParseErrorException;

class SystemModel {


    /**
	 *
     * @var string
     */
    protected $table = '';

    /**
     * @var \PDO|null
     */
    protected $db = null;

	/**
	 * @var string
	 */
    protected $primaryKey = 'id';

	/**
	 * @var array
	 */
	protected $validation = [];

	/**
	 *
	 * @var string
	 */
	protected $create_at = '';

	/**
	 * @var string
	 */
	protected $update_at = '';

    protected $beforeInsert = [];

    protected $beforeUpdate = [];

	protected $ignoredFields = [];

    public function __construct()
    {
        $conn = new Database();
        $this->db = $conn->connect();
    }

	public function __set($name, $value){
		$this->$name = $value;
	}

	/**
	 * Return a last ID
	 * @param $name
	 * @return false|string
	 */
	public function getLastId($name = null)
	{
		return $this->db->lastInsertId($name);
	}

    /**
	 * Return all data
	 * @param string $select
     * @return array|false
     */

    public function findAll($select = '*')
	{
       $res = $this->db->prepare('SELECT '. $select . ' FROM ' . $this->table);
        // $res = $this->db->prepare('SELECT ? FROM );
        $res->execute();
        return $res->fetchAll();
    }

    /**
	 * Find a row with id
     * @param $id
     * @param $select
     * @return mixed
     */
    public function find($id, $select = '*')
    {
        $res = $this->db->prepare('SELECT '. $select . ' FROM ' . $this->table . ' WHERE ' . $this->primaryKey . '=' . $id);
        $res->execute();
        return $res->fetch();
    }

	/**
	 * @param $colmun
	 * @param $search
	 * @return array|false
	 */
    public function like($colmun, $search = ""){
        $res = $this->db->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $colmun . ' LIKE "%' . secure($search) .'%"');
        $res->execute();
        return $res->fetchAll();
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id = null): bool
	{
        if(is_null($id)) return false;
        $res = $this->db->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey . '=' . secure($id));
		return $res->execute();
    }

    /**
     * Insert data into tables
     */
    public function insert($data = []){

        if(! empty($this->beforeInsert)) {
            foreach ($this->beforeInsert as $callback) {
                $data = $this->$callback($data);
            }
        }
        
        // if(empty($data)) throw new ParseErrorException('forEmptyData');

        $insertData =['columns' => '(', 'values' => '('];
        foreach($data as $column => $value) {
            if(empty($value)) continue;

            $insertData['columns'] .= secure($column) .',';
            $insertData['values'] .= '"'. secure($value) .'"' .',';
        }
        if($this->create_at != ''){
            $date = new \DateTime('now', new \DateTimeZone(env('TIMEZONE')));
            $date = $date -> format('Y:m:d h:m:s');  
            $insertData['columns'] .= $this->create_at . ',';
            $insertData['values'] .= '"'. $date .'",';
        }
        $insertData['columns'] = trim($insertData['columns'], ',');
        $insertData['values'] = trim($insertData['values'],',');
        $insertData['columns'] .= ')';
        $insertData['values'] .= ')';
		$res = $this->db->prepare('INSERT INTO ' . $this->table . $insertData['columns'] . ' VALUES'. $insertData['values']);
        return $res->execute();
    }

    /**
     * Update data 
     * 
     */

    public function update($id = null, $data = []){

        if(! empty($this->beforeUpdate)) {
            foreach ($this->beforeUpdate as $callback) {
                $this->$callback($data);
            }
        }
        
        if(empty($data) || is_null($id)) return false;
         
        if($this->update_at != ''){
            $date = new \DateTime('now', new \DateTimeZone(env('TIMEZONE')));
            $date = $date -> format('Y:m:d h:m:s'); 
            $data[$this->update_at] = $date;
        }

        foreach($data as $column => $value) {
//			if(empty($value)) continue;
			$res = $this->db->prepare('UPDATE ' . $this->table . ' SET '. secure($column) . ' = "' . secure($value) . '" WHERE '. $this->primaryKey .'='.$id);
			if(! $res->execute()) return false;
        }
        return true;
	}

    /**
     * Fetch All tables's columns
     */
    public function getAllColumns(): array {
        $res = $this->db->prepare('DESCRIBE '. $this -> table);
        $res->execute();
        return $res->fetchAll();
    }

    /**
     * Return a primary Key
	 * @return string
     */
    
     public function getPrimaryKey(): string{
        return $this->primaryKey;
    }
    
    /**
     *
     */

    public function getIgnoredFields(): array{
        return $this->ignoredFields;
    }

	public function getModel(): string{
		return $this->table;
	}
    public function setModel($name = ''): void{
        $this->table = $name;
    }


    /**
     * @param string $query
     * @return bool|\PDOStatement
     */
    public function builder(string $query = ""): bool|\PDOStatement
	{
        $res = $this->db->prepare($query);
        return $res;
    }


	public function validate(){

	}

}