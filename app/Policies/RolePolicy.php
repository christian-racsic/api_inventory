<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
        public function viewAny(User $user): bool
    {
        if($user->can("list_role")){
            return true;
        }
        return false;
    }

        public function view(User $user, Role $role): bool
    {
        return false;
    }

        public function create(User $user): bool
    {
        if($user->can("register_role")){
            return true;
        }
        return false;
    }

        public function update(User $user, Role $role = null): bool
    {
        if($user->can("edit_role")){
            return true;
        }
        return false;
    }

        public function delete(User $user, Role $role = null): bool
    {
        if($user->can("delete_role")){
            return true;
        }
        return false;
    }

        public function restore(User $user, Role $role): bool
    {
        return false;
    }

        public function forceDelete(User $user, Role $role): bool
    {
        return false;
    }
}
