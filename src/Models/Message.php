<?php

namespace Laralum\Tickets\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laralum_tickets_messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ticket_id', 'user_id', 'message'];

    /**
     * Get the ticket owner owns the message.
     */
    public function user()
    {
        return $this->belongsTo('Laralum\Users\Models\User');
    }

    /**
     * Get the ticket that owns the message.
     */
    public function ticket()
    {
        return $this->belongsTo('Laralum\Tickets\Models\Ticket');
    }

    /**
     * Return true if message is send from user.
     **/
    public function isAdmin()
    {
        return !($this->user->id == $this->ticket->user->id);
    }

    /**
     * Return true if message is send from user.
     **/
    public function isCurrentUser()
    {
        return $this->user->id == Auth::id();
    }
}
