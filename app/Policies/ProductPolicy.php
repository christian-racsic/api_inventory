<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product\Product;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
        public function viewAny(User $user): bool
    {
        if($user->can("list_product")){
            return true;
        }
        return false;
    }

        public function view(User $user, Product $product): bool
    {
        return false;
    }

        public function create(User $user): bool
    {
        if($user->can("register_product")){
            return true;
        }
        return false;
    }

        public function update(User $user, Product $product = null): bool
    {
        if($user->can("edit_product")){
            return true;
        }
        return false;
    }

        public function delete(User $user, Product $product = null): bool
    {
        if($user->can("delete_product")){
            return true;
        }
        return false;
    }

        public function restore(User $user, Product $product): bool
    {
        return false;
    }

        public function forceDelete(User $user, Product $product): bool
    {
        return false;
    }
}
