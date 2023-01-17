<?

namespace App\Models\Migrations;

use System\Database\DatabaseQuery;
use System\Models\MigrationInterface;

class Migration implements MigrationInterface {

    private $db = null;

    public function __construct(){
        $this->db = new DatabaseQuery();
    }

    public function up(){

       $sql = "CREATE TABLE `cf_xxx_users` (`id` int(11) NOT NULL,`username` varchar(255) CHARACTER SET utf8 NOT NULL,`email` VARCHAR(255) NOT NULL,`role` tinyint(1) NOT NULL DEFAULT '0',`password` VARCHAR(255) NOT NULL,`image` VARCHAR(255) NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8;ALTER TABLE `cf_xxx_users` ADD PRIMARY KEY (`id`); ALTER TABLE `cf_xxx_users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";

        return $this->db->query($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS `cf_xxx_users`;";
        return $this->db->query($sql);
    }


    /** DON'T DELETE THIS FUNCTION */

	public function runMigration(){

		return $this -> up();
		// return $this -> down();

	}

}

$migration = new Migration();