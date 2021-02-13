# A Laravel package that can authenticate users using signed links

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jhumanj/laravel-signed-auth-middleware.svg?style=flat-square)](https://packagist.org/packages/jhumanj/laravel-signed-auth-middleware)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/jhumanj/laravel-signed-auth-middleware/run-tests?label=tests)](https://github.com/jhumanj/laravel-signed-auth-middleware/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/jhumanj/laravel-signed-auth-middleware/Check%20&%20fix%20styling?label=code%20style)](https://github.com/jhumanj/laravel-signed-auth-middleware/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/jhumanj/laravel-signed-auth-middleware.svg?style=flat-square)](https://packagist.org/packages/jhumanj/laravel-signed-auth-middleware)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/package-laravel-signed-auth-middleware-laravel.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/package-laravel-signed-auth-middleware-laravel)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require jhumanj/laravel-signed-auth-middleware
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="JhumanJ\LaravelSignedAuthMiddleware\LaravelSignedAuthMiddlewareServiceProvider" --tag="laravel-signed-auth-middleware-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravel-signed-auth-middleware = new JhumanJ\LaravelSignedAuthMiddleware();
echo $laravel-signed-auth-middleware->echoPhrase('Hello, JhumanJ!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please contribute if you want to help me maintain this package or just make it better. Be nice to each other.

## Reporting Issues

For security issues, please contact me directly on twitter []() or via email at [julien@nahum.net](mailto:julien@nahum.net). For any other problems, use the issue tracker here.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
