<?php

namespace Laralum\Tickets\Controllers;
use App\Http\Controllers\Controller;
use Laralum\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laralum\Tickets\Models\Ticket;
use Laralum\Tickets\Models\Message;
use Laralum\Tickets\Models\Settings;
use GrahamCampbell\Markdown\Facades\Markdown;
use League\HTMLToMarkdown\HtmlConverter;

class PublicTicketController extends Controller
{

    /**
     * Display the tickets in laralum administration.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $openedTickets = Ticket::where('user_id', '=', Auth::id())->where('open', true)->orderBy('updated_at','desc')->get();
        $closedTickets = Ticket::where('user_id', '=', Auth::id())->where('open', false)->orderBy('updated_at','desc')->get();

        return view('laralum_tickets::public.index', ['openedTickets' => $openedTickets, 'closedTickets' => $closedTickets]);
    }


    /**
     * Display a form to create tickets on laralum administration.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('publicCreate', Ticket::class);
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
        $this->authorize('publicCreate', Ticket::class);
        $this->validate($request, [
            'subject' => 'required|max:255',
            'message' => 'required|max:2500',
        ]);

        $ticket = Ticket::create([
            'subject' => $request->subject,
            'user_id' => Auth::id(),
            'open' => true,
            'admin_id' => NULL
        ]);

        if (Settings::first()->text_editor == "markdown") {
            $msg = Markdown::convertToHtml($request->message);
        } elseif (Settings::first()->text_editor == "wysiwyg") {
            $msg = $request->message;
        } else {
            $msg = htmlentities($request->message);
        }

        Message::create([
            'message' => $msg,
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('laralum_public::tickets.show', ['ticket' => $ticket->id])
            ->with('success', __('laralum_tickets::general.created'));
    }

    /**
     * Show ticket.
     *
     * @param  \Laralum\Tickets\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $this->authorize('publicView', $ticket);
        return view('laralum_tickets::public.show', ['ticket' => $ticket]);
    }

    /**
     * Display a form to edit tickets on laralum administration.
     *
     * @param  \Illuminate\Http\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        $this->authorize('publicUpdate', $ticket);

        return view('laralum_tickets::public.edit', ['ticket' => $ticket]);
    }

    /**
     * Update tickets on laralum administration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laralum\Tickets\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('publicUpdate', $ticket);

        $this->validate($request, [
            'subject' => 'required|max:255',
        ]);

        $ticket->update([
            'subject' => $request->subject,
        ]);

        return redirect()->route('laralum_public::tickets.show', ['ticket' => $ticket->id])
            ->with('success', __('laralum_tickets::general.updated', ['id' => $ticket->id]));
    }

    /**
     * Open ticket.
     *
     * @param  \Laralum\Tickets\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function open(Ticket $ticket)
    {
        $this->authorize('publicStatus', $ticket);
        $ticket->update([
            'open' => true
        ]);

        return redirect()->route('laralum_public::tickets.index')->with('success', __('laralum_tickets::general.reopened', ['id' => $ticket->id]));
    }

    /**
     * Close ticket.
     *
     * @param  \Laralum\Tickets\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function close(Ticket $ticket)
    {
        $this->authorize('publicStatus', $ticket);
        $ticket->update([
            'open' => false
        ]);
        return redirect()->route('laralum_public::tickets.index')->with('success', __('laralum_tickets::general.closed', ['id' => $ticket->id]));
    }

    /**
     * View for cofirm delete ticket.
     *
     * @param  \Laralum\Tickets\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);
        return view('laralum::pages.confirmation', [
            'method' => 'DELETE',
            'message' => __('laralum_tickets::general.sure_del_ticket', ['id' => $ticket->id]),
            'action' => route('laralum::tickets.destroy', ['ticket' => $ticket->id]),
        ]);
    }

    /**
     * Delete ticket.
     *
     * @param  \Laralum\Tickets\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);
        $ticket->deleteMessages();
        $ticket->delete();
        return redirect()->route('laralum::tickets.index');
    }
}
