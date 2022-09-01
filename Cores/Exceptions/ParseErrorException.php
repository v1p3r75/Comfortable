<?php

namespace System\Exceptions;

class ParseErrorException extends \Exception
{
	public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
	{
		switch ($message){
			case 'forMethod': $message = 'You entered a wrong method !'; $code = 5000; break;
			case 'forCallback': $message = 'You entered a wrong callback for one route !'; $code = 5001; break;
			case 'forEmptyData': $message = 'No data to insert'; $code = 5003; break;
			default: break;

		}
		parent::__construct($message, $code, $previous);
	}
}
