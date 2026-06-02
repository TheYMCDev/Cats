<?php

namespace App\Http\Repositories;

use App\Models\User;
use App\Http\Services\UserService;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserService
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
