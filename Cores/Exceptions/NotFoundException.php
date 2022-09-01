<?php

namespace System\Exceptions;


class NotFoundException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
		switch ($message){
			case 'forPage': $message = 'PAGE NOT FOUND'; $code = 404; break;
			case 'forFile': $message = 'FILE NOT FOUND'; $code = 404; break;
			default: break;
		}
        parent::__construct($message, $code, $previous);
    }
}