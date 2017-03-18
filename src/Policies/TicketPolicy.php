<?php

namespace Laralum\Tickets\Policies;

use Laralum\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Laralum\Ticket\Models\Ticket;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Filters the authoritzation.
     *
     * @param mixed $user
     * @param mixed $ability
     */
    public function before($user, $ability)
    {
        if (User::findOrFail($user->id)->superAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the current user can access tickets module (public).
     *
     * @param  mixed $user
     * @return bool
     */
    public function access($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::tickets.access');
    }

    /**
     * Determine if the current user can access tickets module (public).
     *
     * @param  mixed $user
     * @return bool
     */
    public function publicAccess($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::tickets.access-public');
    }

    /**
     * Determine if the current user can create tickets.
     *
     * @param  mixed  $user
     * @param  Laralum\Ticket\Models\Ticket $ticket
     * @return bool
     */
    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::tickets.create');
    }

    /**
     * Determine if the current user can create tickets (public).
     *
     * @param  mixed  $user
     * @param  Laralum\Ticket\Models\Ticket $ticket
     * @return bool
     */
    public function publicCreate($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::tickets.create-public');
    }


    /**
     * Determine if the current user can view tickets.
     *
     * @param  mixed $user
     * @return bool
     */
    public function view($user, Ticket $ticket)
    {
        if ($ticket->admin_id == $user->id || $ticket->user_id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::tickets.view');
        }
        return False;
    }

    /**
     * Determine if the current user can view tickets (public).
     *
     * @param  mixed $user
     * @return bool
     */
    public function publicView($user, Ticket $ticket)
    {
        if ($ticket->admin_id == $user->id || $ticket->user_id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::tickets.view-public');
        }
        return False;
    }

    /**
     * Determine if the current user can update tickets.
     *
     * @param  mixed $user
     * @return bool
     */
    public function update($user)
    {
        if ($ticket->admin_id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::tickets.update');
        }
        return False;
    }

    /**
     * Determine if the current user can update tickets (public).
     *
     * @param  mixed $user
     * @return bool
     */
    public function publicUpdate($user)
    {
        if ($ticket->admin_id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::tickets.update-public');
        }
        return False;
    }


    /**
     * Determine if the current user can delete tickets.
     *
     * @param  mixed $user
     * @return bool
     */
    public function delete($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::tickets.delete');
    }

    /**
     * Determine if the current user can delete tickets (public).
     *
     * @param  mixed $user
     * @return bool
     */
    public function publicDelete($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::tickets.delete-public');
    }
}
