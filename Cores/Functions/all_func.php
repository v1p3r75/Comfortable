<?php

use System\Exceptions\NotFoundException;

function dump(...$vars): void
{
    echo "<pre>";
    var_dump($vars);
    echo "</pre>";

}
/**
 * Dump vars and exit
 * @param $vars
 */
function dumpExit(...$vars): void
{
    echo "<pre>";
    var_dump($vars);
    echo "</pre>";
	exit();
}

/**
 * Save Env Information
 * @param $envs
 */
function saveEnv(array $envs){
	
	foreach ($envs as $key => $value){
		putenv($key . '=' . $value);
	}

}

/**
 * show template
 * 
 */
function view($filename, $vars = []){
    extract($vars);
    $path = getenv('VIEW_PATH') . $filename . '.php';
    if(! file_exists($path)) throw new NotFoundException("forFile");
    return require($path);
}

function view_admins_image($filename){
    $path = getenv('ADMINS_IMG') . $filename;
    if(! file_exists($path)) throw new NotFoundException("forFile");
    return $path;
}
/**
 * @param $var
 *
 */
function secure($var) {
    if(is_array($var)) return $var;

    return htmlspecialchars($var, ENT_QUOTES);
}

/**
 * @param $var
 * @return array|false|string
 */
function env($var){
    return getenv($var);
}

/**
 * @param $file
 * @return string
 */
function assets($file = "") : string{
    return env('ASSETS_PATH') . $file;
}

/**
 * @param $e
 * @return void
 */
function exceptionManager($e){
	$type = env('SITE_TYPE');
	if($type == 'web'){
		if(env('ENV_TYPE') == 'production') {
			return include(__DIR__ . '/../Pages/production_error.php');
		}
		$static_error = [404,403];
		if(in_array($e->getCode(), $static_error)){
			return include(__DIR__ . '/../Pages/error.php');
		}
		
		return include (__DIR__ . '/../Pages/exceptions.php');
	}else if($type == 'api'){
		header('Content-Type: application/json');
		if(env('ENV_TYPE') == 'production') {
			die(json_encode([
				'code' => 500,
				'message' => 'INTERNAL SERVER ERROR : An error has occured. Please contact the site administrator',
			]));
		}
		echo json_encode([
			'code' => $e->getCode(),
			'message' => $e->getMessage(),
			'file' => $e->getFile(),
			'line' => $e->getLine(),
			'trace' => $e->getTrace(),
			'previous' => $e->getPrevious(),
		]);
	}
}

/**
 * @param $code status code
 * @param $data success or fail data
 * @return void
 */
function sendApiData(array $data = []) {

	echo json_encode($data);
}

// function error_handler($code,$message,$file){
// 	throw new \Exception($message, $code);
// }
// set_error_handler('error_handler');
set_exception_handler('exceptionManager');
