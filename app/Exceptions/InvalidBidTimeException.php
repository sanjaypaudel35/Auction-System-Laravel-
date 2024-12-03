<?php

namespace App\Exceptions;
use Symfony\Component\HttpFoundation\Response;

use Exception;

class InvalidBidTimeException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            message: "Bid is expired or not even started.",
            code: Response::HTTP_FORBIDDEN
        );
    }
}
