<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Client\Client;
use Illuminate\Auth\Access\Response;

class ClientPolicy
{
        public function viewAny(User $user): bool
    {
        if($user->can("list_client")){
            return true;
        }
        return false;
    }

        public function view(User $user, Client $client): bool
    {
        return false;
    }

        public function create(User $user): bool
    {
        if($user->can("register_client")){
            return true;
        }
        return false;
    }

        public function update(User $user, Client $client = null): bool
    {
        if($user->can("edit_client")){
            return true;
        }
        return false;
    }

        public function delete(User $user, Client $client = null): bool
    {
        if($user->can("delete_client")){
            return true;
        }
        return false;
    }

        public function restore(User $user, Client $client): bool
    {
        return false;
    }

        public function forceDelete(User $user, Client $client): bool
    {
        return false;
    }
}
