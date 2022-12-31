<?php
namespace System\Routes;
use System\Exceptions as SystemExceptions;

/**
 * 
*/

class SystemRoutes {

	/**
	 * List of allowed methods
	 * @var array|string[]
	 */
    private $methodsAllowed = ['get','post','put','update','delete'];

	/**
	 * List of saved routes
	 * @var array[]
	 */
    protected $routes = ['get' => [], 'post' => [], 'put' => [], 'update' => [], 'delete' => []];

	/**
	 * Default method for controllers
	 * @var string
	 */
    public $defaultMethod = 'index';

	public $basepath = '/';

    /**
	 * For verify if a method is correct
     * @param string $method
     * @return bool
     */
    private function methodIsCorrect(string $method = ''): bool {
        return in_array(strtolower($method), $this -> methodsAllowed);
    }

	/**
	 * Add the route path
	 * @param string $method
	 * @param string $uri
	 * @param $callback
	 */

	public function add(string $method, string $uri, $callback)
	{
        if(! $this -> methodIsCorrect($method)){
			throw new SystemExceptions\ParseErrorException('forMethod');
        }
        $this -> routes[$method][$uri] = $callback;
    }

	public function get(string $uri, $callback){
		return self::add('get',$uri,$callback);
	}

	public function post(string $uri, $callback){
		return self::add('post',$uri,$callback);
	}

	/**
	 * For run route from uri
	 * @param string $currentURI
	 * @return mixed|void
	 * @throws SystemExceptions\NotFoundException
	 * @throws SystemExceptions\ParseErrorException
	 */
    public function run(string $currentURI = ""){
        $method = strtolower($_SERVER['REQUEST_METHOD']);
       if(! $this -> methodIsCorrect($method)){
           throw new SystemExceptions\ParseErrorException("forMethod");
       }
	   
        if(! key_exists($currentURI, $this->routes[$method])){
            throw new SystemExceptions\NotFoundException('forPage');
        }

        $callback = $this->routes[$method][$currentURI];
        if(is_array($callback)){
            $controller = new $callback[0]();
            $method = $callback[1];
            return $controller->$method();
        }else if(is_callable($callback)){
            return call_user_func($this->routes[$method][$currentURI]);
        }else{
			throw new SystemExceptions\ParseErrorException('forCallback');
		}

	//    $uri = $this->getUri($method);
	//    foreach ($uri as $route) {
	// 	$pattern = '#^'. $route .'#';
	// 	if($route != $this->basepath) 
	// 		if(preg_match($pattern, $currentURI,$matches)){
	// 			// dump($matches);
	// 			$a = preg_replace($pattern,'',$currentURI);
	// 			$params = explode('/',$a);
	// 			dump($route, $currentURI, $a, $params);
	// 		}
	//    }
    }

	/**
	 * Return all routes
	 * @return array[]
	 */
    public function getAllRoutes(): array {
        return $this -> routes;
    }

	private function getUri($currentMethod = ''){
		$uri = [];
		foreach ($this->routes[$currentMethod] as $route => $value){
			$uri[] = $route;
		}
		return $uri;
	}

}