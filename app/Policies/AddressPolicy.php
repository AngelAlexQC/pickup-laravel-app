<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Address;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the address can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list addresses');
    }

    /**
     * Determine whether the address can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Address  $model
     * @return mixed
     */
    public function view(User $user, Address $model)
    {
        return $user->hasPermissionTo('view addresses');
    }

    /**
     * Determine whether the address can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create addresses');
    }

    /**
     * Determine whether the address can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Address  $model
     * @return mixed
     */
    public function update(User $user, Address $model)
    {
        return $user->hasPermissionTo('update addresses');
    }

    /**
     * Determine whether the address can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Address  $model
     * @return mixed
     */
    public function delete(User $user, Address $model)
    {
        return $user->hasPermissionTo('delete addresses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Address  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete addresses');
    }

    /**
     * Determine whether the address can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Address  $model
     * @return mixed
     */
    public function restore(User $user, Address $model)
    {
        return false;
    }

    /**
     * Determine whether the address can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Address  $model
     * @return mixed
     */
    public function forceDelete(User $user, Address $model)
    {
        return false;
    }
}
