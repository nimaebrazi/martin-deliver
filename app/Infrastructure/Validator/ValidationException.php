<?php

namespace App\Infrastructure\Validator;


use RuntimeException;

class ValidationException extends RuntimeException
{
    protected mixed $errors;

    /**
     * ValidationException constructor.
     * @param string $message
     * @param int $code
     * @param mixed $errors
     */
    public function __construct(string $message, int $code, mixed $errors)
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function getErrors(): mixed
    {
        return $this->errors;
    }

    /**
     * @param mixed $errors
     * @return void
     */
    public function setErrors(mixed $errors): void
    {
        $this->errors = $errors;
    }
}
