<?php

namespace Laralum\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laralum_tickets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'open', 'admin_id', 'subject'];

    /**
     * Get ticket user.
     */
    public function user()
    {
        return $this->belongsTo('Laralum\Users\Models\User', 'user_id');
    }

    /**
     * Get ticket administrator.
     */
    public function admin()
    {
        return $this->belongsTo('Laralum\Users\Models\User', 'admin_id');
    }

    /**
     * Get the messages for the ticket.
     */
    public function messages()
    {
        return $this->hasMany('Laralum\Tickets\Models\Message');
    }

    /**
     * Delete ticket messages.
     */
    public function deleteMessages()
    {
        $this->hasMany('Laralum\Tickets\Models\Message')->delete();

        return true;
    }
}
