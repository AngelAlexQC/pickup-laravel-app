<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the ticket can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list tickets');
    }

    /**
     * Determine whether the ticket can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Ticket  $model
     * @return mixed
     */
    public function view(User $user, Ticket $model)
    {
        return $user->hasPermissionTo('view tickets');
    }

    /**
     * Determine whether the ticket can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create tickets');
    }

    /**
     * Determine whether the ticket can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Ticket  $model
     * @return mixed
     */
    public function update(User $user, Ticket $model)
    {
        return $user->hasPermissionTo('update tickets');
    }

    /**
     * Determine whether the ticket can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Ticket  $model
     * @return mixed
     */
    public function delete(User $user, Ticket $model)
    {
        return $user->hasPermissionTo('delete tickets');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Ticket  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete tickets');
    }

    /**
     * Determine whether the ticket can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Ticket  $model
     * @return mixed
     */
    public function restore(User $user, Ticket $model)
    {
        return false;
    }

    /**
     * Determine whether the ticket can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Ticket  $model
     * @return mixed
     */
    public function forceDelete(User $user, Ticket $model)
    {
        return false;
    }
}
