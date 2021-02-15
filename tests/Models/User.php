<?php


namespace JhumanJ\LaravelSignedAuthMiddleware\Tests\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password'];
}
