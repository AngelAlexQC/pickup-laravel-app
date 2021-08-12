<?php

namespace App\Policies;

use App\Models\Road;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the road can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list roads');
    }

    /**
     * Determine whether the road can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Road  $model
     * @return mixed
     */
    public function view(User $user, Road $model)
    {
        return $user->hasPermissionTo('view roads');
    }

    /**
     * Determine whether the road can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create roads');
    }

    /**
     * Determine whether the road can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Road  $model
     * @return mixed
     */
    public function update(User $user, Road $model)
    {
        return $user->hasPermissionTo('update roads');
    }

    /**
     * Determine whether the road can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Road  $model
     * @return mixed
     */
    public function delete(User $user, Road $model)
    {
        return $user->hasPermissionTo('delete roads');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Road  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete roads');
    }

    /**
     * Determine whether the road can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Road  $model
     * @return mixed
     */
    public function restore(User $user, Road $model)
    {
        return false;
    }

    /**
     * Determine whether the road can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Road  $model
     * @return mixed
     */
    public function forceDelete(User $user, Road $model)
    {
        return false;
    }
}
