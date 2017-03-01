@extends('laralum::layouts.public')
@section('title', __('laralum_tickets::general.tickets'))
@section('content')
    <a href="{{ route('laralum_public::tickets.create') }}">@lang('laralum_tickets::general.create_ticket')</a>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>@lang('laralum_tickets::general.subject')</th>
                <th>@lang('laralum_tickets::general.messages')</th>
                <th>@lang('laralum_tickets::general.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $openedTickets as $ticket )
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>
                        <a href="{{route('laralum_public::tickets.show',['ticket' => $ticket->id])}}">
                            {{ $ticket->subject }}
                        </a>
                    </td>
                    <td>{{ $ticket->messages()->count() }}</td>
                    <td>
                        <form action="{{route('laralum_public::tickets.close',['ticket' => $ticket->id])}}"  method="post">
                            {{ csrf_field() }}
                            <button type="submit">@lang('laralum_tickets::general.close')</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @foreach( $closedTickets as $ticket )
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>
                        <a href="{{ route('laralum_public::tickets.show', ['ticket' => $ticket->id]) }}">
                            {{ $ticket->subject }}
                        </a>
                    </td>
                    <td>{{ $ticket->messages()->count() }}</td>
                    <td>
                        <form action="{{ route('laralum_public::tickets.open', ['ticket' => $ticket->id]) }}"  method="post">
                            {{ csrf_field() }}
                            <button type="submit">@lang('laralum::general.open')</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
