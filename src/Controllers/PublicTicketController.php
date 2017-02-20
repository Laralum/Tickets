<?php

namespace Laralum\Tickets\Controllers;
use App\Http\Controllers\Controller;
use Laralum\Users\Models\User;
use Illuminate\Http\Request;
use Laralum\Tickets\Models\Ticket;
use Laralum\Tickets\Models\Message;
use Auth;

class PublicTicketController extends Controller
{
    /**
     * Display all the tickets of this user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $openedTickets = Ticket::where(['user_id' => Auth::id(), 'open' => true])->orderBy('updated_at','desc')->get();
        $closedTickets = Ticket::where(['user_id' => Auth::id(), 'open' => false])->orderBy('updated_at','desc')->get();

        return view('laralum_tickets::public.index', ['openedTickets' => $openedTickets, 'closedTickets' => $closedTickets]);
    }

    /**
     * Display a form to create tickets of this user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laralum_tickets::public.create');
    }

    /**
     * Validate form and user and save ticket and the first message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required|min:6|max:255',
            'message' => 'required|min:10|max:2500'
        ]);


        $ticket = Ticket::create([
            'subject' => $request->subject,
            'user_id' => Auth::id(),
            'open' => true,
        ]);

        Message::create([
            'message' => $request->message,
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('laralum_public::tickets.show', ['ticket' => $ticket->id])->with('success', __('laralum_tickets::general.created'));

    }

    /**
     * Close ticket.
     *
     * @param  \Laralum\Tickets\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function close(Ticket $ticket)
    {
        $ticket->update([
            'open' => false
        ]);

        return redirect()->back()->with('success', __('laralum_tickets::general.closed', ['id' => $ticket]));
    }

    /**
     * Open ticket.
     *
     * @param  \Laralum\Tickets\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function open(Ticket $ticket)
    {
        $ticket->update([
            'open' => true
        ]);

        return redirect()->back()->with('success', __('laralum_tickets::general.reopened', ['id' => $ticket]));

    }

    /**
     * Show ticket messages.
     *
     * @param  \Laralum\Tickets\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        return view('laralum_tickets::public.show', ['ticket' => $ticket]);
    }

    /**
     * Saves the reply.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laralum\Tickets\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request, Ticket $ticket)
    {
        $this->validate($request, [
            'message' => 'required|min:10|max:2500'
        ]);

        Message::create([
            'message' => $request->message,
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('laralum_public::tickets.show', ['ticket' => $ticket])->with('success', __('laralum_tickets::general.reply_sent'));
    }
}
