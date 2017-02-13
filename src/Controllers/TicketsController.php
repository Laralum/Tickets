<?php

namespace Laralum\Tickets\Controllers;
use App\Http\Controllers\Controller;
use Laralum\Users\Models\User;
use Illuminate\Http\Request;
use Auth;

class TicketsController extends Controller
{
    /**
     * Display all the tickets of this user.
     *
     * @return \Illuminate\Http\Response
     */
    public function publicTickets()
    {
        return view('laralum_tickets_public::tickets');
    }



    /**
     * Display the tickets in laralum administration.
     *
     * @return \Illuminate\Http\Response
     */
    public function tickets()
    {
        return view('laralum_tickets::tickets');
    }


}
