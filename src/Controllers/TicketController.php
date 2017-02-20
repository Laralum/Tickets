<?php

namespace Laralum\Tickets\Controllers;
use App\Http\Controllers\Controller;
use Laralum\Users\Models\User;
use Illuminate\Http\Request;
use Auth;
use Laralum\Tickets\Models\Ticket;
use Laralum\Tickets\Models\Message;

class TicketController extends Controller
{

    /**
     * Display the tickets in laralum administration.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $openedTickets = Ticket::where('user_id', '!=', Auth::id())->where('open', true)->orderBy('updated_at','desc')->get();
        $closedTickets = Ticket::where('user_id', '!=', Auth::id())->where('open', false)->orderBy('updated_at','desc')->get();

        return view('laralum_tickets::laralum.index', ['openedTickets' => $openedTickets, 'closedTickets' => $closedTickets]);
    }


    /**
     * Display a form to create tickets on laralum administration.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laralum_tickets::laralum.create');
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
            'email' => 'required',
            'subject' => 'required|min:6|max:255',
            'message' => 'required|min:10|max:2500',
        ]);

        $user = User::where('email', $request->email)->first();

        if ( !$user ) {
            return redirect()->back()->withInput()->with('error', __('laralum_tickets::general.user_not_found', ['email' => $request->email]));
        } elseif( $user == User::findOrFail(Auth::id()) ) {
            return redirect()->back()->withInput()->with('error', __('laralum_tickets::general.cannot_open_ticket_yourself'));
        }

        $ticket = Ticket::create([
            'subject' => $request->subject,
            'user_id' => $user->id,
            'open' => true,
            'admin_id' => Auth::id()
        ]);

        Message::create([
            'message' => $request->message,
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('laralum::tickets.show', ['ticket' => $ticket->id])->with('success', __('laralum_tickets::general.created'));

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
        return redirect()->back()->with('success', __('laralum_tickets::general.closed', ['id' => $ticket->id]));
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
        return redirect()->back()->with('success', __('laralum_tickets::general.reopened', ['id' => $ticket->id]));

    }

    /**
     * Show ticket.
     *
     * @param  \Laralum\Tickets\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        return view('laralum_tickets::laralum.show', ['ticket' => $ticket]);
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

        return redirect()->route('laralum::tickets.show', ['ticket' => $ticket])->with('success', __('laralum_tickets::general.reply_sent'));
    }
}
