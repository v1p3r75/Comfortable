<?php

namespace System\Controllers;
use System\Http\Request;
use System\Http\Response;
use System\Http\Session;

class SystemController {	
	
	protected $request = null;
	protected $respond = null;
	protected $session = null;

	public function __construct()
	{
		$this->request = new Request();
		$this->respond = new Response();
		$this->session = new Session();
	}

	public function validate(){

	}
	
}