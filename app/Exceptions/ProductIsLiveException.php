<?php

namespace App\Exceptions;
use Symfony\Component\HttpFoundation\Response;

use Exception;

class ProductIsLiveException extends Exception
{
    public function __construct(string $message = null)
    {
        parent::__construct(
            message: $message ?? "Action to this product is forbidded.",
            code: Response::HTTP_FORBIDDEN
        );
    }
}
