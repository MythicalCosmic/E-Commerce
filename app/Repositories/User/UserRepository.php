<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\User\UserInterface;

class UserRepository extends BaseRepository implements UserInterface
{
    public function getModel(): string
    {
        return User::class;
    }
}
