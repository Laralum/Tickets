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
        $this->authorize('create', Ticket::class);
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
        $this->authorize('create', Ticket::class);
        $this->validate($request, [
            'email' => 'required|exists:users,email|not_in:'.Auth::user()->email,
            'subject' => 'required|max:255',
            'message' => 'required|max:2500',
        ]);

        $user = User::where('email', $request->email)->first();

        $ticket = Ticket::create([
            'subject' => $request->subject,
            'user_id' => User::where('email', $request->email)->first()->id,
            'open' => true,
            'admin_id' => Auth::id()
        ]);

        Message::create([
            'message' => Markdown::convertToHtml($request->message),
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('laralum::tickets.show', ['ticket' => $ticket->id])->with('success', __('laralum_tickets::general.created'));
    }

    /**
     * Display a form to edit tickets on laralum administration.
     *
     * @param  \Illuminate\Http\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        return view('laralum_tickets::laralum.edit', ['ticket' => $ticket]);
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
        $this->authorize('update', $ticket);

        $ticket->update([
            'subject' => $request->subject,
        ]);

        return redirect()->route('laralum::tickets.show', ['ticket' => $ticket->id])->with('success', __('laralum_tickets::general.updated', ['id' => $ticket->id]));
    }


    /**
     * Display a form to edit tickets messages on laralum administration.
     *
     * @param  \Illuminate\Http\Message $message
     * @return \Illuminate\Http\Response
     */
    public function editMessage(Message $message)
    {
        $this->authorize('update', $message);

        return view('laralum_tickets::laralum.editMessage', ['message' => $message]);
    }

    /**
     * Update tickets messages on laralum administration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laralum\Tickets\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function updateMessage(Request $request, Message $message)
    {
        $this->authorize('update', $message);

        if (Settings::first()->text_editor == "markdown") {
            $msg = Markdown::convertToHtml($request->message);
        } elseif (Settings::first()->text_editor == "wysiwyg") {
            $msg = $request->message;
        } else {
            $msg = htmlentities($request->message);
        }

        $message->update([
            'message' => $msg,
        ]);

        return redirect()->route('laralum::tickets.show', ['ticket' => $message->ticket->id])->with('success', __('laralum_tickets::general.message_updated', ['id' => $message->id]));
    }

    /**
     * Update tickets settings.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function updateSettings(Request $request)
    {
        $this->authorize('update', Settings::class);

        $this->validate($request, [
            'text_editor' => 'required|in:plain-text,markdown,wysiwyg',
            'public_url' => 'required|max:255',
        ]);

        Settings::first()->update([
            'text_editor' => $request->input('text_editor'),
            'public_url' => $request->input('public_url'),
        ]);

        return redirect()->route('laralum::settings.index', ['p' => 'Tickets'])->with('success', __('laralum_tickets::general.tickets_settings_updated'));
    }

    /**
     * Open ticket.
     *
     * @param  \Laralum\Tickets\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function open(Ticket $ticket)
    {
        $this->authorize('open', $ticket);
        $ticket->update([
            'open' => true
        ]);
        return redirect()->back()->with('success', __('laralum_tickets::general.reopened', ['id' => $ticket->id]));

    }

    /**
     * Close ticket.
     *
     * @param  \Laralum\Tickets\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function close(Ticket $ticket)
    {
        $this->authorize('close', $ticket);
        $ticket->update([
            'open' => false
        ]);
        return redirect()->back()->with('success', __('laralum_tickets::general.closed', ['id' => $ticket->id]));
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

    /**
     * View for cofirm delete ticket.
     *
     * @param  \Laralum\Tickets\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function confirmMessageDestroy(Message $message)
    {
        $this->authorize('delete', $message);
        return view('laralum::pages.confirmation', [
            'message' => __('laralum_tickets::general.sure_del_message', ['id' => $message->id]),
            'action' => route('laralum::tickets.messages.destroy', ['message' => $message->id]),
        ]);
    }

    /**
     * Delete ticket.
     *
     * @param  \Laralum\Tickets\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function messageDestroy(Message $message)
    {
        $this->authorize('delete', $message);
        $message->delete();
        return redirect()->route('laralum::tickets.show', ['ticket' => $message->ticket->id]);
    }

    /**
     * Show ticket.
     *
     * @param  \Laralum\Tickets\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
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
        $this->authorize('reply', $ticket);
        $this->validate($request, [
            'message' => 'required|max:2500'
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

        return redirect()->route('laralum::tickets.show', ['ticket' => $ticket])->with('success', __('laralum_tickets::general.reply_sent'));
    }
}
