<?php

namespace JhumanJ\LaravelSignedAuthMiddleware;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SignedAuthMiddlewareServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-signed-auth-middleware')
            ->hasConfigFile('config');
    }

    public function registeringPackage()
    {
        $this->app->singleton('laravel-signed-auth', function ($app) {
            return new SignedAuth();
        });
    }
}
