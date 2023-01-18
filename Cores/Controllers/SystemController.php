<?php

namespace System\Controllers;
use System\Http\Request;
use System\Http\Response;
use System\Http\Session;

class SystemController {	
	
	protected $request = null;

	protected $respond = null;

	protected $session = null;

	protected $twig = null;

	public function __construct()
	{

		$this->request = new Request();
		$this->respond = new Response();
		$this->session = new Session();
		// $this->configRender();

	}

	public function render($template, $data = [])

    {
		// dumpExit($this->twig);
		return $this->twig->render($template);

	}

	public function configRender() {

		$loaderTemplateEngine = new \Twig\Loader\FilesystemLoader();
		$loaderTemplateEngine -> addPath(env('VIEW_PATH'));
		$twig = new \Twig\Environment($loaderTemplateEngine);
		$this->twig = $twig;

	}
	
}