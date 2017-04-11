<?php

namespace Laralum\Tickets\Policies;

use Laralum\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Laralum\Tickets\Models\Ticket;

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
        if ($ability != 'view' && User::findOrFail($user->id)->superAdmin()) {
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
     * @param  Laralum\Ticket\Models\Ticket $ticket
     * @return bool
     */
    public function view($user, Ticket $ticket)
    {
        if ($ticket->user_id != $user->id) {
            return User::findOrFail($user->id)->superAdmin();
        }
        return User::findOrFail($user->id)->hasPermission('laralum::tickets.view');
    }

    /**
     * Determine if the current user can view tickets (public).
     *
     * @param  mixed $user
     * @param  Laralum\Ticket\Models\Ticket $ticket
     * @return bool
     */
    public function publicView($user, Ticket $ticket)
    {
        if ($ticket->user_id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::tickets.view-public');
        }
        return false;
    }

    /**
     * Determine if the current user can update tickets.
     *
     * @param  mixed $user
     * @param  Laralum\Ticket\Models\Ticket $ticket
     * @return bool
     */
    public function update($user, Ticket $ticket)
    {
        if ($ticket->admin_id == $user->id) {
            return true;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::tickets.update');
    }

    /**
     * Determine if the current user can update tickets (public).
     *
     * @param  mixed $user
     * @param  Laralum\Ticket\Models\Ticket $ticket
     * @return bool
     */
    public function publicUpdate($user, Ticket $ticket)
    {
        if ($ticket->user_id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::tickets.update-public');
        }
        return false;
    }

    /**
     * Determine if the current user can delete tickets.
     *
     * @param  mixed $user
     * @param  Laralum\Ticket\Models\Ticket $ticket
     * @return bool
     */
    public function delete($user, Ticket $ticket)
    {
        if ($ticket->admin_id == $user->id) {
            return true;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::tickets.delete');
    }

    /**
     * Determine if the current user can delete tickets (public).
     *
     * @param  mixed $user
     * @param  Laralum\Ticket\Models\Ticket $ticket
     * @return bool
     */
    public function publicDelete($user, Ticket $ticket)
    {
        if ($ticket->user_id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::tickets.delete-public');
        }
        return False;
    }

    /**
     * Determine if the current user can reply this ticket.
     *
     * @param  mixed $user
     * @param  Laralum\Ticket\Models\Ticket $ticket
     * @return bool
     */
    public function reply($user, Ticket $ticket)
    {
        if ($ticket->admin_id == $user->id) {
            return true;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::tickets.reply');
    }

    /**
     * Determine if the current user can reply this ticket.
     *
     * @param  mixed $user
     * @param  Laralum\Ticket\Models\Ticket $ticket
     * @return bool
     */
    public function publicReply($user, Ticket $ticket)
    {
        if ($ticket->user_id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::tickets.reply-public');
        }
        return false;
    }


    /**
     * Determine if the current user can change status of this ticket.
     *
     * @param  mixed $user
     * @param  Laralum\Ticket\Models\Ticket $ticket
     * @return bool
     */
    public function status($user, Ticket $ticket)
    {
        if ($ticket->admin_id == $user->id) {
            return true;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::tickets.status');
    }

    /**
     * Determine if the current user can change status of this ticket.
     *
     * @param  mixed $user
     * @param  Laralum\Ticket\Models\Ticket $ticket
     * @return bool
     */
    public function publicStatus($user, Ticket $ticket)
    {
        if ($ticket->user_id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::tickets.status-public');
        }
        return false;
    }
}
