@extends('laralum::layouts.public')
@section('title', __('laralum_tickets::general.ticket_id', ['id' => $ticket->id]))
@section('content')
    <h2>{{ $ticket->subject }}</h2>
    @foreach ($ticket->messages as $message)
            <div>
                <strong>
                    {{ $message->user->name }}
                    {{ $message->isAdmin() }}
                </strong>
                <span>{{ $message->created_at->diffForHumans() }}</span>
                <br><br>
                {!! GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($message->message) !!}
            </div>
            <br>
    @endforeach
    <form method="POST" action="{{ route('laralum_public::tickets.reply', ['ticket' => $ticket->id]) }}">
        {!! csrf_field() !!}

        <label for="message">@lang('laralum_tickets::general.message')</label><br />
        <textarea class="form-control" id="message" name="message" rows="3">{{ old('message') }}</textarea>
        <i>Markdown syntax supported</i>
        <br>
        <button type="submit">@lang('laralum_tickets::general.reply')</button>
    </form>
@endsection
