<?php

namespace Src\IdentityAndAccess\User\Infrastructure\Repositories;

use App\Models\User as EloquentUser;
use Src\IdentityAndAccess\User\Domain\Contract\UserContract;
use Src\IdentityAndAccess\User\Domain\Entities\User as DomainUser;
use Src\IdentityAndAccess\User\Domain\ValueObjects\Email;
use Src\IdentityAndAccess\User\Domain\ValueObjects\Password;

class EloquentUserRepository implements UserContract
{
    public function create(DomainUser $user): DomainUser
    {
        $eloquent = EloquentUser::create([
            'name' => $user->name(),
            'email' => $user->email()->value(),
            'password' => $user->password()->value()
        ]);

        return new DomainUser(
            $eloquent->name,
            new Email($eloquent->email),
            new Password($eloquent->password, true)
        );
    }


    public function findByEmail(string $email): ?DomainUser
    {
        $eloquent = EloquentUser::where('email', $email)->first();

        if (! $eloquent) {
            return null;
        }

        return new DomainUser(
            $eloquent->name,
            new Email($eloquent->email),
            new Password($eloquent->password, true)
        );
    }
}
