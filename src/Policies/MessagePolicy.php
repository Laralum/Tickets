<?php

namespace Laralum\Tickets\Policies;

use Laralum\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Laralum\Ticket\Models\Message;

class MessagePolicy
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
     * Determine if the current user can update tickets messages.
     *
     * @param  mixed $user
     * @param  Laralum\Ticket\Models\Message $message
     * @return bool
     */
    public function update($user, Message $message)
    {
        if ($message->user->id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::tickets.messages.update');
        }
        return False;
    }


    /**
     * Determine if the current user can delete tickets.
     *
     * @param  mixed $user
     * @param  Laralum\Ticket\Models\Message $message
     * @return bool
     */
    public function delete($user, Message $message)
    {
        if ($message->user->id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::tickets.messages.delete');
        }
        return False;
    }
}
