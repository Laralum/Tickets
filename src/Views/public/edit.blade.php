<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@lang('laralum_tickets::general.edit_ticket', ['id' => $ticket->id]) - {{ Laralum\Settings\Models\Settings::first()->appname }}</title>
    </head>
    <body>
        <h1>@lang('laralum_tickets::general.edit_ticket', ['id' => $ticket->id])</h1>
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

        <form method="POST" action="{{ route('laralum_public::tickets.update',['ticket' => $ticket->id]) }}">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
                <div>
                    <label class="uk-form-label">@lang('laralum_tickets::general.subject')</label>
                    <input value="{{ old('subject', $ticket->subject) }}" name="subject" class="uk-input" type="text" placeholder="@lang('laralum_tickets::general.subject')">
                </div>
                <div>
                    <button type="submit">
                        @lang('laralum::general.edit')
                    </button>
                </div>
        </form>

    </body>
</html>
