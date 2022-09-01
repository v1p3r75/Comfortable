<?php
namespace System\Http;

class Request  {
    
    public function __construct()
    {
        // new request
    }

    /**
	 * Get Value from GET method
	 * @
	 * @param string $key
	 * @return array|string|void
	 */

    public function fromGet(string $key = ''){
        if(!empty($key)) return secure($_GET[$key]);
		return $_GET;
    }

	/**
	 * Get value from POST method
	 * @param string $key
	 * @return array|string|void
	 */

    public function fromPost(string $key = '')
    {
        if(!empty($key)) return secure($_POST[$key]);
        return $_POST;
    }

	public function getUri(string $type = 'string'){
		if($type == 'string') return $_SERVER['REQUEST_URI'];
		else if($type == 'array') return explode('/',$_SERVER['REQUEST_URI']);
		return null;
	}

	public function getUrl(){
		return $_SERVER['REQUEST_URI'];
	}

	public function redirectTo($url = ''){

		return header('Location: ' . $url);
	}

}