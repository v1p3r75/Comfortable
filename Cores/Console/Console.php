<?php

namespace System\Console;
use System\Console\Colors;

class Console
{
	/**
	 * The script arguments
	 * @param array params
	 */
	public $version = '1.0.0';

	private $port = '9000';

	private $params = [];

	private $route = null;

	private $nbParams = null;

	private $commands = [
		'help' => 'For display this text',
		'serve'=> 'for start the framework in local',
		'app' => 'for load the app in console mode',
		'controller:create' => 'for create a controller in console mode',
		'model:create' => 'for create a model in console mode',
		'migration:create' => 'for create a migration in console mode',
		'migration:run' => 'for run a migration in console mode',
		'route:list' => 'List of all routes',
	];
	
	private $welcomeMsg =
	"\n\t\t\t------------------------------------------------------------------\n".
	"\t\t\t----------------------|CERTITUDE INTERFACE|-----------------------\n".
	"\t\t\t------------------------------------------------------------------\n\n";

	public function __construct($argv, $argc, $route){
		$this->params = array_slice($argv,1);
		$this->nbParams = $argc;
		$this->route = $route;
		$this->run();
	}

	public function run() {

		$br = "\n\n";
		$this->params[0] = $this->params[0] ?? 'help';
		
		switch ($this->params[0]) {
			case 'help':
				print $this->colorText($this->welcomeMsg);
				print $this->helpGenerator();
				break;

			case 'serve':
				print $this->colorText($this->welcomeMsg);
				$cmd = 'php -s -S localhost:' . $this->port .' -t /';
				print $this->colorText("$br █==█ Server starting ... $br");
				sleep(1);
				return system($cmd);
				break;
			
			case 'app':
				print $this->colorText($this->welcomeMsg);
				return new AppConsole();
				break;
			
			case 'controller:create':
				$controllerName = $this->params[1] ?? null;
				$controllerName === null ? exit($this->colorText("\nError : You must set the controller name\n",'red')) : null;
				file_put_contents("App/Controllers/" . $controllerName .".php",
				"<?php\nnamespace App\Controllers;\n\nclass " . $controllerName ." extends Controller {\n\n\n}");
				print($this->colorText("$controllerName has been registered to App\Controllers"));
				break;

			case 'model:create':
                $modelName = $this->params[1] ?? null;
                $modelName === null ? exit($this->colorText("\nError : You must set the model name\n",'red')) : null;
				file_put_contents("App/Models/". $modelName.".php", "<?php\nnamespace App\Models;\n\nuse System\Models\SystemModel;\n\nclass " . $modelName ." extends SystemModel {\n\n\n}");
				print($this->colorText("$modelName has been registered to App\Models"));
				break;

			case 'migration:create':
                $migrationName = $this->params[1] ?? null;
                $migrationName === null ? exit($this->colorText("\nError : You must set the migration name\n",'red')) : null;
				file_put_contents("App/Models/migrations/". $migrationName.".php", "<?php\nnamespace App\Models\Migrations;\n\nuse System\Database\DatabaseQuery;\n\nuse System\Models\MigrationInterface;\n\nclass Migration implements MigrationInterface {\n\n\t private \$db = null;\n\n\tpublic function __construct(){\n\n\t\$this->db = new DatabaseQuery();\n\n\t}\n\n\tpublic function up() {}\n\n\tpublic function down(){}\n\n}");
				print($this->colorText("$migrationName has been registered to App\Models\migrations"));
				break;

			case 'migration:run':
				$migrationName = $this->params[1] ?? null;
                $migrationName === null ? exit($this->colorText("\nError : You must set the migration name\n",'red')) : null;
				include "App/Models/migrations/". $migrationName.".php";
				if($migration -> up()) exit($this->colorText("\n $migrationName : was successfully migrated \n",'green'));
				else $this->colorText("\n $migrationName : error while migrating\n",'red');
				break;

			case 'route:list':
				$routes = $this->route->getAllRoutes();
				$methods = $this->route->getAllMethod();

				foreach($routes as $routeMethod => $url) {
					print_r($url);
				}
				break;

			default:
				exit($this->colorText('Command '.$this->params[0] . ' is not found !. For Help : php certitude help', 'red'));
				break;
		}
	}

	/**
	 * Generate a help for AppConsole
	 * @return string
	 */
	private function helpGenerator(): string
	{
		$help = "Certitude Help Center : \n\n" . $this->colorText('Commands :', 'cyan');
		foreach($this->commands as $cmd => $role){
			$help .= "\n\n". $this->colorText($cmd) ."\t\t\t" . $role;
		}
		$help .= $this->colorText("\n\nExample : ") . "php certitude serve\n\n\nPlease visit : ". $this->colorText('https://www.gitub.com/v1p3r75/comfortable', 'cyan') ." for more help\n\n";

		return $help;
	}

	/**
	 * @param $text
	 * @param $color
	 * @param $bg
	 * @return string
	 */
	private function colorText($text, $color = 'green', $bg = null): string
	{
		$colorCode = [
			'black' => '0;30',
			'darkGrey' => '1,30',
			'red' => '0;31',
			'lightRed' => '1;31',
			'green' => '0;32',
			'lightBle' => '1;34',
			'magenta' => '0;35',
			'lightMagenta' => '1;35',
			'cyan' => '0;36',
			'lightCyan' => '1;36',
			'lightGrey' => '0;37',
			'white' => '1;37',
		];
	
		$bgCode = [
			'black' => '40',
			'red' => '41',
			'green' => '42',
			'yellow' => '43',
			'blue' => '44',
			'magenta' => '45',
			'cyan' => '46',
			'lightCyan' => '47',
		];
		
		return !$bg ? "\e[".$colorCode[$color]."m". $text ."\e[0m" : "\e[".$colorCode[$color].";". $bgCode[$bg] . "m" . $text ."\e[0m";
	}


}