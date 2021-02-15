<?php

namespace JhumanJ\LaravelSignedAuthMiddleware\Tests;

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use JhumanJ\LaravelSignedAuthMiddleware\SignedAuthMiddlewareServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();


        $db = new DB();
        $db->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $db->setAsGlobal();
        $db->bootEloquent();

        $this->migrate();
        $this->setupConfig();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'JhumanJ\\LaravelSignedAuthMiddleware\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function setupConfig()
    {
        Config::set('signed-auth-middleware.signature_param_name', 'auth-signature');
    }

    /**
     * Migrate the database.
     *
     * @return void
     */
    protected function migrate()
    {
        DB::schema()->dropAllTables();

        DB::schema()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    protected function getPackageProviders($app)
    {
        return [
            SignedAuthMiddlewareServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        /*
        include_once __DIR__.'/../database/migrations/create_laravel_signed_auth_middleware_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
