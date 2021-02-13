<?php

namespace JhumanJ\LaravelSignedAuthMiddleware;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JhumanJ\LaravelSignedAuthMiddleware\LaravelSignedAuthMiddleware
 */
class LaravelSignedAuthMiddlewareFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-signed-auth-middleware';
    }
}
