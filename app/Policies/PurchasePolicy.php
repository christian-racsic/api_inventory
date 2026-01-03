<?php

namespace App\Policies;


use App\Models\User;
use App\Models\Purchase\Purchase;
use Illuminate\Auth\Access\Response;

class PurchasePolicy
{
        public function viewAny(User $user): bool
    {
        if($user->can("list_purchase")){
            return true;
        }
        return false;
    }

        public function view(User $user, Purchase $purchase): bool
    {
        return false;
    }

        public function create(User $user): bool
    {
        if($user->can("register_purchase")){
            return true;
        }
        return false;
    }

        public function update(User $user, Purchase $purchase = null): bool
    {
        if($user->can("edit_purchase")){
            return true;
        }
        return false;
    }

        public function delete(User $user, Purchase $purchase = null): bool
    {
        if($user->can("delete_purchase")){
            return true;
        }
        return false;
    }

        public function restore(User $user, Purchase $purchase): bool
    {
        return false;
    }

        public function forceDelete(User $user, Purchase $purchase): bool
    {
        return false;
    }
}
