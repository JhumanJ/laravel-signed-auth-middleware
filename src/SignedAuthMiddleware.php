<?php

namespace JhumanJ\LaravelSignedAuthMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use JhumanJ\LaravelSignedAuthMiddleware\Exceptions\ExpiredSignatureException;
use JhumanJ\LaravelSignedAuthMiddleware\Exceptions\InvalidSignatureException;

class SignedAuthMiddleware
{
    private $urlGenerator;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     *
     */
    public function handle($request, Closure $next)
    {
        if ($this->isSignedAuthRequest($request)) {
            // Validate link
            if (! $this->urlGenerator->hasCorrectSignature($request)) {
                throw new InvalidSignatureException();
            } elseif (! $this->urlGenerator->signatureHasNotExpired($request)) {
                throw new ExpiredSignatureException();
            }

            // Auth user
            $user = $this->getUser($request);
            $guard = $user->guard_name ?? config('signed-auth-middleware.user_guard');
            $rememberLogin = $user->should_remember_login ?? config('signed-auth-middleware.remember_login');

            if (method_exists(Auth::guard($guard), 'login')) {
                Auth::guard($guard)->login($user, $rememberLogin);
                abort_unless($user == Auth::guard($guard)->user(), 401);
            }
        }

        return $next($request);
    }

    private function getUser($request)
    {
        return Auth::guard(config('signed-auth-middleware.user_guard'))
            ->getProvider()
            ->retrieveById($request->get('uid'));
    }

    private function isSignedAuthRequest(Request $request)
    {
        return $request->has(config('signed-auth-middleware.signature_param_name')) &&
            $request->get(config('signed-auth-middleware.signature_param_name'));
    }
}
