<?php


namespace JhumanJ\LaravelSignedAuthMiddleware\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException as Exception;

class InvalidSignatureException extends \Illuminate\Routing\Exceptions\InvalidSignatureException
{}
