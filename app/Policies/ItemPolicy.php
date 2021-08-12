<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the item can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list items');
    }

    /**
     * Determine whether the item can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Item  $model
     * @return mixed
     */
    public function view(User $user, Item $model)
    {
        return $user->hasPermissionTo('view items');
    }

    /**
     * Determine whether the item can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create items');
    }

    /**
     * Determine whether the item can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Item  $model
     * @return mixed
     */
    public function update(User $user, Item $model)
    {
        return $user->hasPermissionTo('update items');
    }

    /**
     * Determine whether the item can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Item  $model
     * @return mixed
     */
    public function delete(User $user, Item $model)
    {
        return $user->hasPermissionTo('delete items');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Item  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete items');
    }

    /**
     * Determine whether the item can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Item  $model
     * @return mixed
     */
    public function restore(User $user, Item $model)
    {
        return false;
    }

    /**
     * Determine whether the item can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Item  $model
     * @return mixed
     */
    public function forceDelete(User $user, Item $model)
    {
        return false;
    }
}
