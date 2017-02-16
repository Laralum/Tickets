@extends('laralum::layouts.public')
@section('title', trans('laralum_tickets::tickets.reply_ticket'))
@section('content')

<form method="POST">
    {!! csrf_field() !!}

    <label for="message">@lang('laralum_tickets::tickets.message')</label>
    <textarea class="form-control" id="message" name="message" rows="3">{{ old('message') }}</textarea>
    <i>Markdown syntax supported</i>
    <br>
    <a href="{{route('laralum_public::tickets.show',['ticket' => $ticket->id])}}">@lang('laralum::general.cancel')</a>
    <button type="submit">@lang('laralum_tickets::tickets.reply')</button>
</form>

@endsection
