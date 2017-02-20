@extends('laralum::layouts.master')
@section('icon', 'ion-pricetags')
@section('title', trans('laralum_tickets::general.tickets'))
@section('subtitle', trans('laralum_tickets::general.tickets_desc'))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_tickets::general.home')</a></li>
        <li><span href="">@lang('laralum_tickets::general.tickets')</span></li>
    </ul>
@endsection
@section('content')
<div class="uk-container uk-container-large">
    <div class="uk-card uk-card-default uk-card-body uk-width-1-1">

        {{-- Tabs --}}
        <ul class="uk-subnav uk-subnav-pill" uk-switcher>
            <li><a href="#">Opened Tickets</a></li>
            <li><a href="#">Closed Tickets</a></li>
        </ul>

        {{-- Content of tabs --}}
        <ul class="uk-switcher uk-margin">
            <li>
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('laralum_tickets::general.subject')</th>
                                <th>@lang('laralum::general.user')</th>
                                <th>@lang('laralum_tickets::general.messages')</th>
                                <th>@lang('laralum::general.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($openedTickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>
                                        <a href="{{route('laralum::tickets.show',['ticket' => $ticket->id])}}" title="{{trans('laralum_tickets::general.show_ticket',['id' => '#'.$ticket->id])}}" uk-tooltip="pos: top-left">
                                            {{$ticket->subject}}
                                        </a>
                                    </td>
                                    <td>{{Laralum\Users\Models\User::findOrFail($ticket->user_id)->email}}</td>
                                    <td>{{$ticket->messages()->count()}}</td>
                                    <td class="uk-table-shrink">
                                        <div class="uk-button-group">
                                            <form action="{{route('laralum::tickets.close',['ticket' => $ticket->id])}}"  method="post">
                                                {{ csrf_field() }}
                                                <button type="submit" class="uk-button uk-button-small uk-button-primary">Close</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </li>
            <li>
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('laralum_tickets::general.subject')</th>
                                <th>@lang('laralum::general.user')</th>
                                <th>@lang('laralum_tickets::general.messages')</th>
                                <th>@lang('laralum::general.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($closedTickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>
                                        <a href="{{route('laralum::tickets.show',['ticket' => $ticket->id])}}" title="{{trans('laralum_tickets::general.show_ticket',['id' => '#'.$ticket->id])}}" uk-tooltip="pos: top-left">
                                            {{$ticket->subject}}
                                        </a>
                                    </td>
                                    <td>{{Laralum\Users\Models\User::findOrFail($ticket->user_id)->email}}</td>
                                    <td>{{$ticket->messages()->count()}}</td>
                                    <td class="uk-table-shrink">
                                        <div class="uk-button-group">
                                            <form action="{{route('laralum::tickets.open',['ticket' => $ticket->id])}}"  method="post">
                                                {{ csrf_field() }}
                                                <button type="submit" class="uk-button uk-button-small uk-button-primary">Open</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </li>
        </ul>
    </div>
</div>
@endsection
