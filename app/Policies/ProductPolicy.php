<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product)
    {
        return $user->id === $product->user_id
            ? Response::allow()
            : Response::deny('You do not have permission to update products posted by others.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product)
    {
        return $user->id === $product->user_id
            ? Response::allow()
            : Response::deny('You do not have the right to delete products posted by others.');
    }
}
