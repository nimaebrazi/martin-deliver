<?php

namespace App\Exceptions;

class AuthenticationException extends \Illuminate\Auth\AuthenticationException
{
    public function __construct($message = 'Unauthenticated.', array $guards = [], $redirectTo = null)
    {
        $this->code = 403;
        parent::__construct($message, $guards, $redirectTo);
    }
}
