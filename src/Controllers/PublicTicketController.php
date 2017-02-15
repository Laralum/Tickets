<?php

namespace Laralum\Tickets\Controllers;
use App\Http\Controllers\Controller;
use Laralum\Users\Models\User;
use Illuminate\Http\Request;
use Auth;
use Laralum\Tickets\Models\Ticket;
use Laralum\Tickets\Models\Message;

class PublicTicketController extends Controller
{


    /**
     * Display all the tickets of this user.
     *
     * @return \Illuminate\Http\Response
     */
    public function tickets()
    {
        $openedTickets = Ticket::where(['user_id' => Auth::id(), 'opened' => true])->orderBy('updated_at','desc')->get();
        $closedTickets = Ticket::where(['user_id' => Auth::id(), 'opened' => false])->orderBy('updated_at','desc')->get();

        return view('laralum_tickets::public.index', ['openedTickets' => $openedTickets, 'closedTickets' => $closedTickets]);
    }

    /**
     * Display a form to create tickets of this user.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTicket()
    {
        return view('laralum_tickets::public.create');
    }



    /**
     * Validate form and user and save ticket and the first message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveTicket(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required|min:6|max:255',
            'message' => 'required|min:10|max:2500'
        ]);


        $ticket = Ticket::create([
            'subject' => $request->subject,
            'user_id' => Auth::id(),
            'opened' => true,
        ]);

        Message::create([
            'message' => $request->message,
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('laralum_public::tickets.show', ['ticket' => $ticket->id])->with('success',trans('laralum_tickets::tickets.created'));

    }

    /**
     * Close ticket.
     *
     * @param $ticket
     * @return \Illuminate\Http\Response
     */
    public function closeTicket($ticket)
    {
        Ticket::findOrFail($ticket)->update([
            'opened' => false
        ]);
        return redirect()->route('laralum_public::tickets.index')->with('success', trans('laralum_tickets::tickets.closed', ['id' => '#'.$ticket]));
    }

    /**
     * Open ticket.
     *
     * @param $ticket
     * @return \Illuminate\Http\Response
     */
    public function openTicket($ticket)
    {
        Ticket::findOrFail($ticket)->update([
            'opened' => true
        ]);
        return redirect()->route('laralum_public::tickets.index')->with('success', trans('laralum_tickets::tickets.reopened', ['id' => '#'.$ticket]));

    }

    /**
     * Show ticket messages.
     *
     * @param $ticket
     * @return \Illuminate\Http\Response
     */
    public function showTicket($ticket)
    {
        $thisTicket = Ticket::findOrFail($ticket);
        $messages = $thisTicket->messages;
        return view('laralum_tickets::public.show', ['ticket' => $thisTicket, 'messages' => $messages]);

    }


    /**
     * Display a reply form.
     *
     * @param $ticket
     * @return \Illuminate\Http\Response
     */
    public function replyTicket($ticket)
    {
        $thisTicket = Ticket::findOrFail($ticket);
        return view('laralum_tickets::public.reply', ['ticket' => $thisTicket]);

    }

    /**
     * Saves the reply.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param $ticket
     * @return \Illuminate\Http\Response
     */
    public function saveTicketReply(Request $request, $ticket)
    {
        $this->validate($request, [
            'message' => 'required|min:10|max:2500'
        ]);

        Message::create([
            'message' => $request->message,
            'ticket_id' => Ticket::findOrFail($ticket)->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('laralum_public::tickets.show', ['ticket' => $ticket])->with('success',trans('laralum_tickets::tickets.reply_sent'));

    }
}
