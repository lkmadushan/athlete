<?php namespace Athlete\Filters;

use Exception;

class UnauthorizedUserException extends Exception
{

    public function __construct($message = 'Invalid credentials!')
    {
        parent::__construct($message);
    }
}
