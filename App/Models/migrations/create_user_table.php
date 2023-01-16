<?php
namespace App\Models\Migrations;

use System\Database\DatabaseQuery;

use System\Models\MigrationInterface;

class Migration implements MigrationInterface {

	 private $db = null;

	public function __construct(){

	$this->db = new DatabaseQuery();

	}

	public function up() {}

	public function down(){}

}

/* DON'T DELETE THIS LINE */
$migration = new Migration();