@extends('laralum::layouts.public')
@section('title', trans('laralum_tickets::tickets.ticket_id', ['id' => '#'.$ticket->id]))
@php
    $settings = Laralum\Settings\Models\Settings::first();
@endphp
@section('content')
    <h2>{{$ticket->subject}}</h2>
    @foreach ($messages as $message)
            <div style="background-color:{{$message->color()}};">
                <strong>
                    @if ($message->isAdmin())
                        @lang('laralum_tickets::tickets.customer_support',['name' => $settings->appname])
                    @else
                        {{Laralum\Users\Models\User::findOrFail($message->user_id)->name}}
                    @endif
                </strong>
                <span>{{$message->created_at->diffForHumans()}}</span>
                <br><br>
                {{$message->message}}
            </div>
            <br>
    @endforeach
    <a href="{{route('laralum_public::tickets.reply', ['ticket' => $ticket->id])}}">@lang('laralum_tickets::tickets.send_a_reply')</a>
@endsection
