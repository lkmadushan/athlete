<?php namespace Athlete\Filters;

use Exception;

class ApiKeyMismatchException extends Exception
{

    public function __construct($message = 'Valid api key is required!')
    {
        parent::__construct($message);
    }
}
