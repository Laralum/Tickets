@extends('laralum::layouts.public')
@section('title', trans('laralum_tickets::tickets.tickets'))
@section('content')
    <a href="{{route('laralum_public::tickets.create')}}">@lang('laralum_tickets::tickets.create')</a>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>@lang('laralum_tickets::tickets.subject')</th>
                <th>@lang('laralum_tickets::tickets.messages')</th>
                <th>@lang('laralum::general.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($openedTickets as $ticket)
                <tr>
                    <th>{{$ticket->id}}</th>
                    <td>
                        <a href="{{route('laralum_public::tickets.show',['ticket' => $ticket->id])}}">
                            {{$ticket->subject}}
                        </a>
                    </td>
                    <td>{{$ticket->messages()->count()}}</td>
                    <td>
                            <form action="{{route('laralum_public::tickets.close',['ticket' => $ticket->id])}}"  method="post">
                                {{ csrf_field() }}
                                <button type="submit">@lang('laralum::general.close')</button>
                            </form>
                    </td>
                </tr>
            @endforeach
            @foreach ($closedTickets as $ticket)
                <tr>
                    <th>{{$ticket->id}}</th>
                    <td>
                        <a href="{{route('laralum_public::tickets.show',['ticket' => $ticket->id])}}">
                            {{$ticket->subject}}
                        </a>
                    </td>
                    <td>{{$ticket->messages()->count()}}</td>
                    <td>
                            <form action="{{route('laralum_public::tickets.open',['ticket' => $ticket->id])}}"  method="post">
                                {{ csrf_field() }}
                                <button type="submit">@lang('laralum::general.open')</button>
                            </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
