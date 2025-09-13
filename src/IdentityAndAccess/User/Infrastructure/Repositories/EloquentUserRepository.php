<?php

namespace Src\IdentityAndAccess\User\Infrastructure\Repositories;

use App\Models\User as EloquentUser;
use Src\IdentityAndAccess\User\Domain\Entities\User as DomainUser;
use Src\IdentityAndAccess\User\Domain\Contract\UserContract;

class EloquentUserRepository implements UserContract
{
    public function create(DomainUser $user): DomainUser
    {
        $eloquent = EloquentUser::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->passwordHash,
        ]);

        return new DomainUser($eloquent->name, $eloquent->email, $eloquent->password);
    }

    public function findByEmail(string $email): ?DomainUser
    {
        $eloquent = EloquentUser::where('email', $email)->first();

        return $eloquent
            ? new DomainUser($eloquent->name, $eloquent->email, $eloquent->password)
            : null;
    }
}
