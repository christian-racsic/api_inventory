<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Sale\Sale;
use Illuminate\Auth\Access\Response;

class SalePolicy
{
        public function viewAny(User $user): bool
    {
        if($user->can("list_sale")){
            return true;
        }
        return false;
    }

        public function view(User $user, Sale $sale): bool
    {
        return false;
    }

        public function create(User $user): bool
    {
        if($user->can("register_sale")){
            return true;
        }
        return false;
    }

        public function update(User $user, Sale $sale = null): bool
    {
        if($user->can("edit_sale")){
            return true;
        }
        return false;
    }

        public function delete(User $user, Sale $sale = null): bool
    {
        if($user->can("delete_sale")){
            return true;
        }
        return false;
    }

        public function restore(User $user, Sale $sale): bool
    {
        return false;
    }

        public function forceDelete(User $user, Sale $sale): bool
    {
        return false;
    }
}
