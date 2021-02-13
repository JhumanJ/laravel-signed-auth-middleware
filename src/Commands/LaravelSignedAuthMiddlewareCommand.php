<?php

namespace JhumanJ\LaravelSignedAuthMiddleware\Commands;

use Illuminate\Console\Command;

class LaravelSignedAuthMiddlewareCommand extends Command
{
    public $signature = 'laravel-signed-auth-middleware';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
