@extends('laralum::layouts.master')
@section('icon', 'ion-pricetag')
@section('title', trans('laralum_tickets::general.ticket_id', ['id' => '#'.$ticket->id]))
@section('subtitle', $ticket->subject)
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_tickets::general.home')</a></li>
        <li><a href="{{ route('laralum::tickets.index') }}">@lang('laralum_tickets::general.ticket_lists')</a></li>
        <li><span>@lang('laralum_tickets::general.show_ticket',['id' => $ticket->id])</span></li>
    </ul>
@endsection
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
    <div class="uk-container uk-container-large">
        @foreach ($messages as $message)
            <div uk-grid>
                @if($message->isCurrentUser())
                    <div class="uk-width-1-6@s uk-width-1-5@m"></div>
                @endif
                @php
                    $class = $message->isAdmin() ? $message->isCurrentUser() ?  'ticket-bubble-right ticket-thisadmin-color' : 'ticket-bubble-left ticket-admin-color' : ' ticket-bubble-left ticket-user-color' ;
                @endphp
                <div class="uk-width-5-6@s uk-width-4-5@m">
                    <div class="uk-card uk-card-default {{$class}}" uk-scrollspy="cls: uk-animation-slide-{{$message->isCurrentUser() ? 'right' : 'left'}}; repeat: false">
                        <div style="background-color:{{ $message->titleColor() }}" class="uk-card-header">
                            <h3 class="uk-card-title" style="color:white;">
                                @if ($message->isAdmin())
                                    @lang('laralum_tickets::general.customer_support',['name' => $settings->appname])
                                @else
                                    {{Laralum\Users\Models\User::findOrFail($message->user_id)->name}}
                                @endif
                                <span class="uk-float-right">{{$message->created_at->diffForHumans()}}</span>
                            </h3>
                        </div>
                        <div class="uk-card-body" style="background-color:{{ $message->color() }};color:black">
                            {!! GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($message->message) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <br><br>
        <div uk-grid>
            <div class="uk-width-1-3"></div>
            <a class="uk-button uk-button-default uk-button-primary uk-width-1-3" href="{{route('laralum::tickets.reply', ['ticket' => $ticket->id])}}">@lang('laralum_tickets::general.send_a_reply')</a>
        </div>
    </div>

@endsection
