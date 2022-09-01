<?php
namespace System\Http;

class Session {

	public function __construct()
	{
		//session_name(env('APP_NAME') ?? null);
	}

	static function get(string $key = '')
    {
		return $_SESSION[$key] ?? false;
    }

	static function set($key, $value): void
	{
		$_SESSION[$key] = $value;
	}

	static function setArray(array $data): void
	{
		foreach ($data as $key => $value){
			$_SESSION[$key] = $value;
		}
	}
}