<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@lang('laralum_tickets::general.tickets') - {{ Laralum\Settings\Models\Settings::first()->appname }}</title>
    </head>
    <body>
        <h1>@lang('laralum_tickets::general.tickets')</h1>
        @if(Session::has('success'))
            <hr>
            <p style="color:green">
                {{Session::get('success')}}
            </p>
            <hr>
        @endif
        @if(Session::has('info'))
            <hr>
            <p style="color:blue">
                {{Session::get('info')}}
            </p>
            <hr>
        @endif
        @if(Session::has('error'))
            <hr>
            <p style="color:red">
                {{Session::get('error')}}
            </p>
            <hr>
        @endif
        @if(count($errors->all()))
            <hr>
            <p style="color:red">
                @foreach($errors->all() as $error) {{$error}}<br/>@endforeach
            </p>
            <hr>
        @endif

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
                            @can('publicStatus', $ticket)
                                <form action="{{route('laralum_public::tickets.close',['ticket' => $ticket->id])}}"  method="post">
                                    {{ csrf_field() }}
                                    <button type="submit">@lang('laralum_tickets::general.close')</button>
                                </form>
                            @endcan
                            @can('publicUpdate', $ticket)
                                <a href="{{ route('laralum_public::tickets.edit', ['ticket' => $ticket->id]) }}">
                                    @lang("laralum_tickets::general.edit")
                                </a>
                            @endcan
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
                            @can('publicStatus', $ticket)
                                <form action="{{ route('laralum_public::tickets.open', ['ticket' => $ticket->id]) }}"  method="post">
                                    {{ csrf_field() }}
                                    <button type="submit">@lang('laralum::general.open')</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </body>
</html>
