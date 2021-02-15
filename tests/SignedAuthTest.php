<?php

namespace JhumanJ\LaravelSignedAuthMiddleware\Tests;

use Illuminate\Support\Str;
use JhumanJ\LaravelSignedAuthMiddleware\Exceptions\ExpiredSignatureException;
use JhumanJ\LaravelSignedAuthMiddleware\Exceptions\InvalidSignatureException;
use JhumanJ\LaravelSignedAuthMiddleware\Facades\SignedAuth;
use JhumanJ\LaravelSignedAuthMiddleware\SignedAuthMiddleware;
use JhumanJ\LaravelSignedAuthMiddleware\Tests\Models\User;

class SignedAuthTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => "Julien Nahum",
            'email' => "julien@nahum.net",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', SignedAuthMiddleware::class);
    }

    /**
     * Define routes setup.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    protected function defineRoutes($router)
    {
        $router->get('hello', ['as' => 'hello', 'middleware' => SignedAuthMiddleware::class, 'uses' => function () {
            return 'hello world';
        }]);
    }

    /** @test */
    public function test_signed_auth_request()
    {
        $this->assertGuest();
        $signedAuthUrl = SignedAuth::forUser($this->user)
            ->route('hello')
            ->generate();

        $response = $this->get($signedAuthUrl);
        $response->assertSuccessful();
        $response->assertSee('hello world');

        $this->assertAuthenticatedAs($this->user);
    }

    /** @test */
    public function test_without_signature_no_auth()
    {
        $this->assertGuest();

        $response = $this->get(route('hello'));
        $response->assertSuccessful();
        $response->assertSee('hello world');

        $this->assertGuest();
    }

    /** @test */
    public function test_tampered_signature_throws()
    {
        $this->withoutExceptionHandling();
        $this->assertGuest();

        $signedAuthUrl = SignedAuth::forUser($this->user)
            ->route('hello')
            ->generate();

        $this->expectException(InvalidSignatureException::class);
        $this->get($signedAuthUrl.'tampered');
    }

    /** @test */
    public function test_signed_auth_request_without_expiration()
    {
        $this->withoutExceptionHandling();
        $this->assertGuest();

        $signedAuthUrl = SignedAuth::forUser($this->user)
            ->neverExpires()
            ->route('hello')
            ->generate();

        $this->assertFalse(str_contains($signedAuthUrl, 'expires'));
        $response = $this->get($signedAuthUrl);
        $response->assertSuccessful();
        $response->assertSee('hello world');

        $this->assertAuthenticatedAs($this->user);
    }

    public function test_expired_request_will_not_auth()
    {
        $this->withoutExceptionHandling();
        $this->assertGuest();

        $signedAuthUrl = SignedAuth::forUser($this->user)
            ->expires(-1)
            ->route('hello')
            ->generate();

        $this->expectException(ExpiredSignatureException::class);
        $this->get($signedAuthUrl);
    }

    /** @test */
    public function test_signed_auth_request_with_custom_params()
    {
        $this->withoutExceptionHandling();
        $this->assertGuest();
        $signedAuthUrl = SignedAuth::forUser($this->user)
            ->route('hello', [
                'utm_stupid' => 'tracked',
            ])
            ->generate();

        $this->assertTrue(str_contains($signedAuthUrl, "utm_stupid=tracked"));
        $response = $this->get($signedAuthUrl);
        $response->assertSuccessful();
        $response->assertSee('hello world');

        $this->assertAuthenticatedAs($this->user);
    }
}
