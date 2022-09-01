<?php 
namespace System\Database;

use System\Database\Database;

class DatabaseQuery {

    private $db = null;

    public function __construct()
    {
        $conn = new Database();
        $this->db = $conn -> connect();
    }
    
    /**
     * Get All database tables
     */
    public function getAllTables(){
        $res = $this->db->prepare('SHOW TABLES');
        $res->execute();
        return $res -> fetchAll();
    }

    /**
     * @param $query
     * @return false|\PDOStatement
     */
    public function query($query = ""){
        $res = $this->db->prepare($query);
        return $res->execute();
    }

	public function tableExist(string $tab){

		$data = $this->getAllTables();
		foreach($data as $table => $value){
			foreach ($value as $tableName){
				if($tableName === $tab) return true;
			}
		}
		return false;
	}

}