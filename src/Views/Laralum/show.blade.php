@extends('laralum::layouts.master')
@section('icon', 'mdi-tag')
@section('title', trans('laralum_tickets::tickets.ticket_id', ['id' => '#'.$ticket->id]))
@section('subtitle', $ticket->subject)
@section('css')
    <style media="screen">
    .ticket-bubble-right:before {
        content: "";
        width: 0;
        position: absolute;
        border-style: solid;
        border-width: 30px 0px 0px 50px;
        bottom: -30px;
        right: 20px;
    }

    .ticket-bubble-left:before {
        content: "";
        width: 0;
        position: absolute;
        border-style: solid;
        border-width: 30px 50px 0px 0px;
        bottom: -30px;
        left: 20px;
    }

    .ticket-admin-color:before {
        border-color:#FFCDD2 transparent transparent transparent;
    }

    .ticket-thisadmin-color:before {
        border-color:#EF9A9A transparent transparent transparent;
    }
    .ticket-user-color:before {
        border-color:#B2DFDB transparent transparent transparent;
    }

    </style>
@endsection
@php
    $settings = Laralum\Settings\Models\Settings::first();
@endphp
@section('content')
<div class="row">
    @foreach ($messages as $message)
        <div class="col col-11 col-lg-8 @if($message->isCurrentUser()) offset-1 offset-lg-4 @endif" style="margin-bottom:35px;">
            @php
                $class = $message->isAdmin() ? $message->isCurrentUser() ?  'ticket-bubble-right ticket-thisadmin-color' : 'ticket-bubble-left ticket-admin-color' : ' ticket-bubble-left ticket-user-color' ;
            @endphp
            <div class="card shadow {{$class}}" style="height:100%;background-color:{{$message->color()}};">
                <div class="card-header shadow" style="height:100%;background-color:{{$message->titleColor()}};color:white">
                    <strong>
                        @if ($message->isAdmin())
                            @lang('laralum_tickets::tickets.customer_support',['name' => $settings->appname])
                        @else
                            {{Laralum\Users\Models\User::findOrFail($message->user_id)->name}}
                        @endif
                    </strong>
                    <span class="float-right">{{$message->created_at->diffForHumans()}}</span>
                </div>
                <div class="card-block">
                    {{$message->message}}
                </div>
            </div>

        </div>
    @endforeach
</div>
<br><br>
<div class="row">
    <div class="col-12">
        <center>
            <a href="{{route('laralum::tickets.reply', ['ticket' => $ticket->id])}}" class="btn btn-primary" role="button">@lang('laralum_tickets::tickets.send_a_reply')</a>
        </center>
    </div>
</div>

@endsection
