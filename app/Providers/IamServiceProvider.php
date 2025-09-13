<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\IdentityAndAccess\User\Domain\Contract\UserContract;
use Src\IdentityAndAccess\User\Infrastructure\Repositories\EloquentUserRepository;

class IamServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserContract::class, EloquentUserRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
