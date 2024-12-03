<?php

namespace App\Exceptions;
use Symfony\Component\HttpFoundation\Response;

use Exception;

class PaymentFailed extends Exception
{
    public function __construct(string $message = "Payment is failed. Try again later.")
    {
        parent::__construct(
            message: $message,
            code: Response::HTTP_FORBIDDEN
        );
    }
}
