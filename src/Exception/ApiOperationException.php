<?php

namespace App\Exception;

use RuntimeException;
use Throwable;

class ApiOperationException extends RuntimeException
{
    private array $errors = [];

    public function __construct(array $errors, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        if(!empty($errors)){
            $this->errors = $errors;
        }

        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
