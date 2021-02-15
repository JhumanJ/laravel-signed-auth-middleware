<?php

namespace JhumanJ\LaravelSignedAuthMiddleware;

use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Support\Facades\URL;

class SignedAuth
{
    const NEVER_EXPIRES = 'never';

    private string $routeName;
    private array $routeParams = [];
    private bool $routeAbsolute = false;

    private $expires;

    private User $user;

    public function forUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function expires($minutes = null)
    {
        $this->expires = now()->addMinutes($minutes ?? config('laravel-signed-auth-middleware.login_route_expires'));
        return $this;
    }

    public function neverExpires()
    {
        $this->expires = self::NEVER_EXPIRES;
        return $this;
    }

    public function route($name, $params = [], $absolute = true)
    {
        $this->routeName = $name;
        $this->routeParams = $params;
        $this->routeAbsolute = $absolute;
        return $this;
    }

    public function generate()
    {
        if ($this->expires == self::NEVER_EXPIRES) {
            $url = URL::signedRoute(
                $this->routeName,
                array_merge(
                    $this->routeParams,
                    $this->getMandatoryParams()
                ));
            return $url;
        } else if ($this->expires == null) {
            // Default expire
            $this->expires = now()->addMinutes( config('laravel-signed-auth-middleware.login_route_expires'));
        }

        return URL::temporarySignedRoute(
            $this->routeName,
            $this->expires,
            array_merge(
                $this->routeParams,
                $this->getMandatoryParams(),
            ),
            $this->routeAbsolute
        );
    }

    private function getMandatoryParams()
    {
        return [
            config('laravel-signed-auth-middleware.signature_param_name') => true,
            'uid' => $this->user->getAuthIdentifier(),
            'utype' => ClassSlugManager::toSlug(get_class($this->user)),
        ];
    }
}
