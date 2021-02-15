<?php


namespace JhumanJ\LaravelSignedAuthMiddleware\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException as Exception;

class ExpiredSignatureException extends Exception
{
    public function __construct()
    {
        parent::__construct(410);
    }
}
