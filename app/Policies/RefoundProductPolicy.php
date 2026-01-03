<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Sale\RefoundProduct;
use Illuminate\Auth\Access\Response;

class RefoundProductPolicy
{
        public function viewAny(User $user): bool
    {
        if($user->can("")){

        }
        return false;
    }

        public function view(User $user, RefoundProduct $refoundProduct): bool
    {
        return false;
    }

        public function create(User $user): bool
    {
        return false;
    }

        public function update(User $user, RefoundProduct $refoundProduct): bool
    {
        return false;
    }

        public function delete(User $user, RefoundProduct $refoundProduct): bool
    {
        return false;
    }

        public function restore(User $user, RefoundProduct $refoundProduct): bool
    {
        return false;
    }

        public function forceDelete(User $user, RefoundProduct $refoundProduct): bool
    {
        return false;
    }
}
