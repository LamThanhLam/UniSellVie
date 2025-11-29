<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;
    
    // Admin Bypass: Admin can skip all authorization-checks
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
    
    /**
     * Determine only Seller/Admin can access management page.
     */
    public function viewAny(User $user)
    {
        return $user->isSeller() 
            ? Response::allow()
            : Response::deny('You have no right to manage the product.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        return false;
    }

    /**
     * Determine only Seller/Admin can create products.
     */
    public function create(User $user)
    {
        return $user->isSeller() 
            ? Response::allow()
            : Response::deny('You have no right to sell the product.');
    }

    /**
     * Determine only Owner or Admin can update.
     */
    public function update(User $user, Product $product)
    {
        return $user->id === $product->user_id
            ? Response::allow()
            : Response::deny('You can only update your own product.');
    }

    /**
     * Determine only Owner or Admin can delete.
     */
    public function delete(User $user, Product $product)
    {
        return $user->id === $product->user_id
            ? Response::allow()
            : Response::deny('You can only delete your own product.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return false;
    }
}
