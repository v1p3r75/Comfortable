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
    public $methodsAllowed = ['get','post','put','update','delete'];

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

	/**
     * Request object
     * @var 
     */
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

	/**
	 * Add get url path to route
	 * @param string $uri The route uri
	 * @param $callback 
	 * @return mixed|void
	 */
	public function get(string $uri, $callback){

		return $this->add('get',$uri,$callback);
	}

	/**
	 * Add post url path to route
	 * @param string $uri The route uri
	 * @param $callback 
	 * @return mixed|void
	 */

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
    public function run($middlewares, string $currentURI = ""){
		
        $method = trim(strtolower($this->request->getMethod()), '/');

       if(! $this -> methodIsCorrect($method)){
           throw new SystemExceptions\ParseErrorException("forMethod");
       }

	   foreach ($this->routes[$method] as $route => $callback) {
			
			// if(preg_match_all("/{(\w+)(:[^}]+)?}/", $route, $matches)){
			// 	$routeNames = $matches[1];
			// }
			$routeRegex = "@^" . preg_replace_callback("/{(\w+)(:[^}]+)?}/", fn($m) => isset($m[2]) ? "({$m[2]})" : "(\w+)", $route) . "$@";

			if(preg_match_all($routeRegex, $currentURI, $matches)){
				
				$params = [];
				for ($i = 1; $i < count($matches); $i++) {
					$params[] = $matches[$i][0]; // List of parameters that will parse to function

				}

				// $middlewares -> getAll();

				if(is_array($callback)){ // If callback is an array (class, method)

					$controller = new $callback[0]();
					$method = $callback[1] ?? $this->defaultMethod;
					return call_user_func_array([$controller, $method], $params);

				}else if(is_callable($callback)){ // If callback is a function (closure)

					return call_user_func_array($callback, $params);

				}
			}

	   }
	   throw new SystemExceptions\NotFoundException('forPage');
    }

	/**
	 * Return all routes
	 * @return array[]
	 */
    public function getAllRoutes(): array {
        return $this -> routes;
    }

	/**
	 * Return all methods
	 * @return array[]
	 */

	public function getAllMethod(): array {

		return $this->methodsAllowed;
	}

}