<?php

namespace System\Database;

class Database {
	
    private $__db = null;

	/**
	 * For Database Connection
	 * @param DB_DSN
	 * @param string DB_USERNAME
	 * @param string DB_PASSWORD
	 * @param array OPTIONS
	 * @throws \Exception
	 */
	public function connect(): \PDO
	{
		$__dbMySqlDSN = 'mysql:host=' . env('DB_HOST').';dbname='. env('DB_NAME') .';charset='. env('DB_CHARSET') . ';';
		$this->__db = new \PDO($__dbMySqlDSN, env('DB_USERNAME'), env('DB_PASSWORD'),
			[
				\PDO::ATTR_PERSISTENT => env('DB_PERSISTENT') ?? true,
			]
		);
		$this->__db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$this->__db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
		
        return $this->__db;
    }

	/**
	 * Destroy database connection
	 * @return void
	 */
	public function disconnect(): void {
		$this->__db = null;
	}


}