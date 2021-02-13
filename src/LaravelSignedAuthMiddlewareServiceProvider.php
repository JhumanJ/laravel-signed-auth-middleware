<?php

namespace JhumanJ\LaravelSignedAuthMiddleware;

use JhumanJ\LaravelSignedAuthMiddleware\Commands\LaravelSignedAuthMiddlewareCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelSignedAuthMiddlewareServiceProvider extends PackageServiceProvider
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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_signed_auth_middleware_table')
            ->hasCommand(LaravelSignedAuthMiddlewareCommand::class);
    }
}
