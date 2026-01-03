<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
        public function viewAny(User $user): bool
    {
        if($user->can("list_user")){
            return true;
        }
        return false;
    }

        public function view(User $user, User $model): bool
    {
        return false;
    }

        public function create(User $user): bool
    {
        if($user->can("register_user")){
            return true;
        }
        return false;
    }

        public function update(User $user, User $model = null): bool
    {
        if($user->can("edit_user")){
            return true;
        }
        return false;
    }

        public function delete(User $user, User $model = null): bool
    {
        if($user->can("delete_user")){
            return true;
        }
        return false;
    }

        public function restore(User $user, User $model): bool
    {
        return false;
    }

        public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
