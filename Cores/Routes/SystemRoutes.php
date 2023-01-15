<?php
namespace System\Routes;
use System\Exceptions as SystemExceptions;
use System\Http\Request;

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

	public $request = null;


	public function __construct(){

		$this->request = new Request();

	}

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

		return $this->add('get',$uri,$callback);
	}

	public function post(string $uri, $callback){

		return $this->add('post',$uri,$callback);
	}

	/**
	 * For run route from uri
	 * @param string $currentURI
	 * @return mixed|void
	 * @throws SystemExceptions\NotFoundException
	 * @throws SystemExceptions\ParseErrorException
	 */
    public function run(string $currentURI = ""){

        $method = trim(strtolower($this->request->getMethod()), '/');

       if(! $this -> methodIsCorrect($method)){
           throw new SystemExceptions\ParseErrorException("forMethod");
       }

	   foreach ($this->routes[$method] as $route => $callback) {
			
			if(preg_match_all("/{(\w+)(:[^}]+)?}/", $route, $matches)){
				$routeNames = $matches[1];
			}
			$routeRegex = "@^" . preg_replace_callback("/{(\w+)(:[^}]+)?}/", fn($m) => isset($m[2]) ? "({$m[2]})" : "(\w+)", $route) . "$@";

			if(preg_match_all($routeRegex, $currentURI, $matches)){
				//return dump($matches);
				$params = [];
				for ($i = 1; $i < count($matches); $i++) {
					$params[] = $matches[$i][0];
				}

				if(is_array($callback)){ // If callback is an array (class, method)

					$controller = new $callback[0]();
					$method = $callback[1];
					// return $controller->$method($params);
					return call_user_func_array([$controller, $method], $params);


				}else if(is_callable($callback)){ // If callback is a function (closure)

					return call_user_func_array($callback, $params);

				}else{
					continue;
				}
			}else {
			// 	dump($routeRegex,$route, $currentURI);
				// dump($this->getAllRoutes());
				continue;
				// throw new SystemExceptions\NotFoundException('forPage');
			} 

	   }
	//    exit();
    //     if(! key_exists($currentURI, $this->routes[$method])){
    //     }

    //     $callback = $this->routes[$method][$currentURI];
    //     if(is_array($callback)){
    //         $controller = new $callback[0]();
    //         $method = $callback[1];
	// 		// return var_dump($_SERVER['REQUEST_URI']);
    //         return $controller->$method();
    //     }else if(is_callable($callback)){
	// 		// return var_dump($_SERVER['REQUEST_URI']);
    //         return call_user_func($this->routes[$method][$currentURI]);
    //     }else{
	// 		throw new SystemExceptions\ParseErrorException('forCallback');
	// 	}

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

}