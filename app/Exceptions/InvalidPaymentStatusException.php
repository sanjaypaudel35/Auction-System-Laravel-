<?php

namespace App\Exceptions;
use Symfony\Component\HttpFoundation\Response;

use Exception;

class InvalidPaymentStatusException extends Exception
{
    public function __construct(string $message = null)
    {
        parent::__construct(
            message: $message,
            code: Response::HTTP_FORBIDDEN
        );
    }
}
