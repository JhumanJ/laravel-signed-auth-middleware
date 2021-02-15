<?php

namespace JhumanJ\LaravelSignedAuthMiddleware\Tests\Unit;

use JhumanJ\LaravelSignedAuthMiddleware\ClassSlugManager;
use JhumanJ\LaravelSignedAuthMiddleware\Tests\TestCase;

class ClassSlugManagerTest extends TestCase
{
    /** @test **/
    public function make_from_class()
    {
        $slug = ClassSlugManager::toSlug('HelloWorld\\ModelsFolder\\User');

        $this->assertEquals('hello_world-models_folder-user', $slug);
    }

    /** @test **/
    public function make_from_slug()
    {
        $userClass = ClassSlugManager::fromSlug('hello_world-models_folder-user');

        $this->assertEquals('HelloWorld\\ModelsFolder\\User', $userClass);
    }
}
