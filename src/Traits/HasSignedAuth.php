<?php

namespace JhumanJ\LaravelSignedAuthMiddleware\Traits;

trait HasSignedAuth
{
    /**
     * Sets SignedAuthMiddleware priority to be more important than the auth middleware
     */
    public function setupSignedAuthMiddleware()
    {
        $this->middlewarePriority = array_splice(
            $this->middlewarePriority,
            array_search(\Illuminate\Auth\Middleware\Authorize::class, $this->middlewarePriority),
            0,
            \JhumanJ\LaravelSignedAuthMiddleware\SignedAuthMiddleware::class
        );
    }
}
