# Laravel Signed Auth Middleware

---

## A simple, safe magic login link generator for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jhumanj/laravel-signed-auth-middleware.svg?style=flat-square)](https://packagist.org/packages/jhumanj/laravel-signed-auth-middleware)
[![GitHub Tests Action Status](https://github.com/jhumanj/laravel-signed-auth-middleware/workflows/Tests/badge.svg)](https://github.com/jhumanj/laravel-signed-auth-middleware/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/jhumanj/laravel-signed-auth-middleware/Check%20&%20fix%20styling?label=code%20style)](https://github.com/jhumanj/laravel-signed-auth-middleware/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/jhumanj/laravel-signed-auth-middleware.svg?style=flat-square)](https://packagist.org/packages/jhumanj/laravel-signed-auth-middleware)

This packages allows you to generate links that will authenticate your users. You can use this for password-less
applications, or simply to authenticate users from links your application sends (via email, text message etc.).

## Why this package

I started to use [laravel-passwordless-login](https://github.com/grosv/laravel-passwordless-login) package
by [grosv](https://github.com/grosv) and it worked very well. Unfortunately, because of the redirection, I had some
troubles with Google analytics and UTM tracking. I wanted to extend the package, but then realized that there wasn't a
trivial solution, as utm tracking parameters should not be used in the context of intenal website navigation. Hence I
created this package, which is very strongly inspired by
[laravel-passwordless-login](https://github.com/grosv/laravel-passwordless-login).

Signed Auth Middleware package allows you to generate signed links that will automatically authenticate your users using
a middleware (without any redirect).
Unlike [laravel-passwordless-login](https://github.com/grosv/laravel-passwordless-login), this package does not support
the `use-once` link feature.

## Installation

You can install the package via composer:

```bash
composer require jhumanj/laravel-signed-auth-middleware
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-signed-auth-middleware-config" 
```

This is the contents of the published config file:

```php
return [
    'signature_param_name' => 'auth-signature', 
    'default_expire' => 60,
    'remember_login' => true,
    'user_guard' => 'web'
];
```

## Usage

### Setting up middleware

The first thing to do is to setup the middleware. The middleware needs to be registered before the auth middleware. You
can achieve that by adding the `HasSignedAuth` trait to your `App\Http\Kernel.php` file:

```php
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use JhumanJ\LaravelSignedAuthMiddleware\Traits\HasSignedAuth;

class Kernel extends HttpKernel
{
    use HasSignedAuth;

    // ... 
    
    public function __construct(Application $app, Router $router)
    {
        parent::__construct($app, $router);

        $this->setupSignedAuthMiddleware();
    }
}
```

Then you have two options: use the middleware on all or your routes or not. To add the middleware to all your routes,
add the middleware to the web middleware group.

```php 
   // App/Http/Kernel.php
   
   protected $middlewareGroups = [
        'web' => [
            // ...
            \JhumanJ\LaravelSignedAuthMiddleware\SignedAuthMiddleware::class,
        ],
    ];
```

Now if you don't want to use the middleware on all of your web routes you can also define a route middleware like this:

```php
// Kernel.php
protected $routeMiddleware = [
    'auth.signed' => \JhumanJ\LaravelSignedAuthMiddleware\SignedAuthMiddleware::class,
];
```

And then use it as follows in your route file:
```php 
// routes/web.php
Route::get('/', function () {
    return view('welcome');
})->middleware('auth.signed','auth');
```

### Creating auth signed links

Here is how to generate a signed link that will authenticate your users:
```php 
use JhumanJ\LaravelSignedAuthMiddleware\Facades\SignedAuth;

$signedUrl = SignedAuth::forUser($user)
                ->route('welcome')
                ->generate();
```
You can also override the default expiry time:
```php 
use JhumanJ\LaravelSignedAuthMiddleware\Facades\SignedAuth;

$signedUrl = SignedAuth::forUser($user)
                ->expired(60*24) // expires in 24 hours
                ->route('welcome')
                ->generate();
```

Or you set it to never expire:
```php 
use JhumanJ\LaravelSignedAuthMiddleware\Facades\SignedAuth;

$signedUrl = SignedAuth::forUser($user)
                ->neverExpires()
                ->route('welcome')
                ->generate();
```

If you need to add some more parameters, just proceed as you would do it with the normal `route()` method:
```php 
use JhumanJ\LaravelSignedAuthMiddleware\Facades\SignedAuth;

$signedUrl = SignedAuth::forUser($user)
                ->route('welcome',[
                    'utm_source' => 'source',
                    'utm_medium' => 'medium',
                    'utm_campaign' => 'utm_campaign'
                ])
                ->generate();
```

## Testing

Please make sure that all package tests are running successfully before sending a pull request.

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please contribute if you want to help me maintain this package or just make it better. Be nice to each other.

## Reporting Issues

For security issues, please contact me directly on [twitter](https://twitter.com/JhumanJ) or via email
at [julien@nahum.net](mailto:julien@nahum.net). For any other problems, use the issue tracker here.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
