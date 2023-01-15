<?php

namespace System\Console;

class Console
{
	/**
	 * The script arguments
	 * @param array params
	 */
	public $version = '1.0.0';
	private $port = '9000';
	private $params = [];

	private $nbParams = null;
	private $commands = [
		'help' => 'For display this text',
		'serve'=> 'for start the framework in local',
		'app' => 'for load the app in console mode'
	];
	
	private $welcomeMsg =
	"\n\t\t\t------------------------------------------------------------------\n".
	"\t\t\t----------------------|WELCOME TO CERTITUDE|----------------------\n".
	"\t\t\t------------------------------------------------------------------\n\n";

	public function __construct($argv, $argc){
		$this->params = array_slice($argv,1);
		$this->nbParams = $argc;
		$this->run();
	}

	public function run() {
		$br = "\n\n";
		print $this->colorText($this->welcomeMsg, 'black', 'green');
		$this->params[0] = $this->params[0] ?? 'help';
		
		switch ($this->params[0]) {
			case 'help':
				print $this->helpGenerator();
				break;

			case 'serve':
				$cmd = 'php -S localhost:' . $this->port .' -t public';
				print $this->colorText("$br █==█ Server starting ... $br");
				sleep(1);
				return system($cmd);
				break;
			
			case 'app':
				return new AppConsole();
				break;
			
			case 'create::controller':
				$controllerName = $this->params[1] ?? null;
				$controllerName === null ? exit($this->colorText("\nError : You must set the controller name\n",'red')) : null;
				file_put_contents("App/Controllers/" . $controllerName .".php",
				"<?php\nnamespace App\Controllers;\n\nclass " . $controllerName ." extends Controller {\n\n\n}");
				break;

			case 'route::list':
				// list app routes
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
		$help .= $this->colorText("\n\nExample : ") . "php certitude serve\n\n\nPlease visit : ". $this->colorText('http://www.gitub.com/v1p3r75/conmfortable') ." for more help\n\n";

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