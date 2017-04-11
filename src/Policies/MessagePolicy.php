<?php

namespace Laralum\Tickets\Policies;

use Laralum\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Laralum\Tickets\Models\Message;

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
        if ($message->user_id == $user->id || $message->admin_id == $user->id) {
            return true;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::tickets.messages.update');
    }

    /**
     * Determine if the current user can update tickets messages.
     *
     * @param  mixed $user
     * @param  Laralum\Ticket\Models\Message $message
     * @return bool
     */
    public function publicUpdate($user, Message $message)
    {
        if ($message->user_id == $user->id || $message->admin_id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::tickets.messages.update-public');
        }
        return false;
    }

    /**
     * Determine if the current user can delete ticket messages.
     *
     * @param  mixed $user
     * @param  Laralum\Ticket\Models\Message $message
     * @return bool
     */
    public function delete($user, Message $message)
    {
        if ($message->user_id == $user->id || $message->admin_id == $user->id) {
            return true;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::tickets.messages.delete');
    }

    /**
     * Determine if the current user can delete ticket messages.
     *
     * @param  mixed $user
     * @param  Laralum\Ticket\Models\Message $message
     * @return bool
     */
    public function publicDelete($user, Message $message)
    {
        if ($message->user_id == $user->id || $message->admin_id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::tickets.messages.delete-public');
        }
        return false;
    }
}
