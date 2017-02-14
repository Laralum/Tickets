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
    protected $fillable = ['creator', 'user_id', 'admin_id', 'subject', 'description'];

    /**
     * Get the message for the ticket.
     */
    public function messages()
    {
        return $this->hasMany('Laralum\Tickets\Models\Message');
    }

}
