@extends('laralum::layouts.master')
@section('icon', 'ion-pricetags')
@section('title', __('laralum_tickets::general.ticket_list'))
@section('subtitle', __('laralum_tickets::general.tickets_desc'))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_tickets::general.home')</a></li>
        <li><span href="">@lang('laralum_tickets::general.ticket_list')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div class="uk-card uk-card-default uk-width-1-1">
            <div class="uk-card-header">
                @lang('laralum_tickets::general.ticket_list')
            </div>

            <div class="uk-card-body">

                {{-- Tabs --}}
                <ul uk-tab uk-switcher>
                    <li><a href="#">@lang('laralum_tickets::general.open_tickets')</a></li>
                    <li><a href="#">@lang('laralum_tickets::general.closed_tickets')</a></li>
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
                                    @forelse( $openedTickets as $ticket )
                                        <tr>
                                            <td>{{ $ticket->id }}</td>
                                            <td>
                                                <a href="{{route('laralum::tickets.show',['ticket' => $ticket->id])}}" title="{{trans('laralum_tickets::general.show_ticket',['id' => '#'.$ticket->id])}}" uk-tooltip="pos: top">
                                                    {{ $ticket->subject }}
                                                </a>
                                            </td>
                                            <td>{{ $ticket->user->email }}</td>
                                            <td>{{ $ticket->messages()->count() }}</td>
                                            <td class="uk-table-shrink">
                                                <div class="uk-button-group">
                                                    <a href="{{ route('laralum::tickets.show', ['ticket' => $ticket->id]) }}" class="uk-button uk-button-small uk-button-default">@lang('laralum_tickets::general.view')</a>
                                                    <form action="{{ route('laralum::tickets.close', ['ticket' => $ticket->id]) }}"  method="post">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="uk-button uk-button-small uk-button-primary">Close</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                    @endforelse
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
                                        <th>@lang('laralum_tickets::general.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse( $closedTickets as $ticket )
                                        <tr>
                                            <td>{{ $ticket->id }}</td>
                                            <td>
                                                <a href="{{route('laralum::tickets.show',['ticket' => $ticket->id])}}" title="{{trans('laralum_tickets::general.show_ticket',['id' => '#'.$ticket->id])}}" uk-tooltip="pos: top-left">
                                                    {{ $ticket->subject }}
                                                </a>
                                            </td>
                                            <td>{{ $ticket->user->email }}</td>
                                            <td>{{ $ticket->messages()->count() }}</td>
                                            <td class="uk-table-shrink">
                                                <div class="uk-button-group">
                                                    <a href="{{ route('laralum::tickets.show', ['ticket' => $ticket->id]) }}" class="uk-button uk-button-small uk-button-default">@lang('laralum_tickets::general.view')</a>
                                                    <form action="{{ route('laralum::tickets.open', ['ticket' => $ticket->id]) }}"  method="post">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="uk-button uk-button-small uk-button-primary">@lang('laralum_tickets::general.open')</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
