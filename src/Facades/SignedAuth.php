<?php

namespace JhumanJ\LaravelSignedAuthMiddleware\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JhumanJ\LaravelSignedAuthMiddleware\SignedAuthMiddleware
 */
class SignedAuth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-signed-auth';
    }
}
