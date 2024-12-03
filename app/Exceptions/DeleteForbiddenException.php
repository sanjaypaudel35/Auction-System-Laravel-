<?php

namespace App\Exceptions;
use Symfony\Component\HttpFoundation\Response;

use Exception;

class DeleteForbiddenException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            message: "You are not allowed to delete.",
            code: Response::HTTP_FORBIDDEN
        );
    }
}
