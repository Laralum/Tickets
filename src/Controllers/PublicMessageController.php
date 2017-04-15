<?php

namespace Laralum\Tickets\Controllers;

use App\Http\Controllers\Controller;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laralum\Tickets\Models\Message;
use Laralum\Tickets\Models\Settings;
use Laralum\Tickets\Models\Ticket;

class PublicMessageController extends Controller
{
    /**
     * Store messages on laralum administration.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Ticket $ticket)
    {
        $this->authorize('publicReply', $ticket);
        $this->validate($request, [
            'message' => 'required|max:2500',
        ]);

        if (Settings::first()->text_editor == 'markdown') {
            $msg = Markdown::convertToHtml($request->message);
        } elseif (Settings::first()->text_editor == 'wysiwyg') {
            $msg = $request->message;
        } else {
            $msg = htmlentities($request->message);
        }

        Message::create([
            'message'   => $msg,
            'ticket_id' => $ticket->id,
            'user_id'   => Auth::id(),
        ]);

        return redirect()->route('laralum_public::tickets.show', ['ticket' => $ticket])
            ->with('success', __('laralum_tickets::general.reply_sent'));
    }

    /**
     * Display a form to edit tickets on laralum administration.
     *
     * @param \Illuminate\Http\Ticket $ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        $this->authorize('publicUpdate', $message);

        return view('laralum_tickets::public.editMessage', ['message' => $message]);
    }

    /**
     * Update tickets messages on laralum administration.
     *
     * @param \Illuminate\Http\Request        $request
     * @param \Laralum\Tickets\Models\Message $message
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        $this->authorize('publicUpdate', $message);

        $this->validate($request, [
            'message' => 'required|max:2500',
        ]);

        if (Settings::first()->text_editor == 'markdown') {
            $msg = Markdown::convertToHtml($request->message);
        } elseif (Settings::first()->text_editor == 'wysiwyg') {
            $msg = $request->message;
        } else {
            $msg = htmlentities($request->message);
        }

        $message->update([
            'message' => $msg,
        ]);

        return redirect()->route('laralum_public::tickets.show', ['ticket' => $message->ticket->id])
            ->with('success', __('laralum_tickets::general.message_updated', ['id' => $message->id]));
    }

    /**
     * Delete message.
     *
     * @param \Laralum\Tickets\Models\Message $message
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $this->authorize('publicDelete', $message);
        $message->delete();

        return redirect()->route('laralum_public::tickets.show', ['ticket' => $message->ticket->id]);
    }
}
