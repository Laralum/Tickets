@extends('laralum::layouts.master')
@php
    $settings = \Laralum\Tickets\Models\Settings::first();
@endphp
@section('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.5/tinymce.min.js"></script>
    @if ($settings->text_editor == 'wysiwyg')
        <script>
            tinymce.init({ selector:'textarea',   plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ] });
        </script>
    @endif
@endsection
@section('icon', 'ion-pricetag')
@section('title', $ticket->subject)
@section('subtitle', __('laralum_tickets::general.ticket_subtitle', ['id' => $ticket->id, 'created' => $ticket->created_at->diffForHumans()]))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_tickets::general.home')</a></li>
        <li><a href="{{ route('laralum::tickets.index') }}">@lang('laralum_tickets::general.ticket_list')</a></li>
        <li><span>@lang('laralum_tickets::general.show_ticket',['id' => $ticket->id])</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-1-1@m uk-width-1-3@l">
                <div class="uk-card uk-card-default" uk-sticky="media: 640; bottom: true; offset: 120;">
                    <div class="uk-card-header">
                        @lang('laralum_tickets::general.ticket_information')
                    </div>
                    <div class="uk-card-body">
                        <div uk-grid>
                            <div class="uk-width-1-2">
                                <h4>@lang('laralum_tickets::general.ticket_status')</h4>
                                @if($ticket->open)
                                    <span class="uk-label uk-label-success">@lang('laralum_tickets::general.ticket_open')</span>
                                @else
                                    <span class="uk-label uk-label-danger">@lang('laralum_tickets::general.ticket_closed')</span>
                                @endif
                            </div>
                            <div class="uk-width-1-2">
                                <h4>@lang('laralum_tickets::general.creation_date')</h4>
                                <span>{{ $ticket->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="uk-width-1-2 uk-text-truncate">
                                <h4>@lang('laralum_tickets::general.user_name')</h4>
                                <span>{{ $ticket->user->name }}</span>
                            </div>
                            <div class="uk-width-1-2 uk-text-truncate">
                                <h4>@lang('laralum_tickets::general.user_email')</h4>
                                <span>{{ $ticket->user->email }}</span>
                            </div>
                            @can('status', $ticket)
                                <div class="uk-width-1-1">
                                    @if($ticket->open)
                                        <form action="{{ route('laralum::tickets.close', ['ticket' => $ticket->id]) }}"  method="post">
                                            {{ csrf_field() }}
                                            <button type="submit" class="uk-button uk-button-danger uk-width-1-1 uk-margin-small-bottom">@lang('laralum_tickets::general.close_ticket', ['id' => $ticket->id])</button>
                                        </form>
                                    @else
                                        <form action="{{ route('laralum::tickets.open', ['ticket' => $ticket->id]) }}"  method="post">
                                            {{ csrf_field() }}
                                            <button type="submit" class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">@lang('laralum_tickets::general.reopen_ticket', ['id' => $ticket->id])</button>
                                        </form>
                                    @endif
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1@m uk-width-2-3@l">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-body">
                        @foreach ($ticket->messages as $message)
                            <article class="uk-comment">
                                <header class="uk-comment-header uk-grid-medium uk-flex-middle" uk-grid>
                                    <div class="uk-width-auto">
                                        <img class="uk-comment-avatar uk-border-circle" src="{{ $message->user->avatar() }}" width="80" height="80" alt="">
                                    </div>
                                    <div class="uk-width-expand">
                                        <h4 class="uk-comment-title uk-margin-remove">
                                            {{ $message->user->name }}
                                            @if($message->isAdmin())
                                                <span class="uk-label">@lang('laralum_tickets::general.customer_support')</span>
                                            @endif
                                        </h4>
                                        <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                                            <li><a href="#">{{ $message->created_at->diffForHumans() }}</a></li>
                                        </ul>
                                    </div>
                                </header>
                                <div class="uk-comment-body">
                                    {!! $message->message !!}
                                </div>
                                @if ( \Illuminate\Support\Facades\Auth::user()->can('update', $message) || \Illuminate\Support\Facades\Auth::user()->can('delete', $message))
                                    <br>
                                    <div>
                                        @can ('update', $message)
                                            <a class="uk-button uk-button-text" href="{{ route('laralum::tickets.messages.edit', ['message' => $message->id]) }}">@lang('laralum_tickets::general.edit')</a>&emsp;
                                        @endcan
                                        @can ('delete', $message)
                                            <a class="uk-button uk-button-text" href="{{ route('laralum::tickets.messages.destroy.confirm', ['message' => $message->id]) }}">@lang('laralum_tickets::general.delete')</a>
                                        @endcan
                                    </div>
                                @endif
                            </article>
                            @if( !$loop->last )
                                <hr />
                            @endif
                        @endforeach
                        @can('reply', $ticket)
                            <h4>@lang('laralum_tickets::general.send_a_reply')</h4>
                            <form action="{{ route('laralum::tickets.messages.store', ['ticket' => $ticket->id]) }}" method="POST">
                                {{ csrf_field() }}
                                <fieldset class="uk-fieldset">
                                    <div class="uk-margin">
                                        @if ($settings->text_editor == 'wysiwyg')
                                            <textarea name="message">
                                                {{ old('message') }}
                                            </textarea>
                                        @else
                                            <textarea name="message" class="uk-textarea" rows="5" placeholder="{{ __('laralum_tickets::general.message') }}">{{ old('message') }}</textarea>
                                            @if ($settings->text_editor == 'markdown')
                                                <i>@lang('laralum_tickets::general.markdown')</i>
                                            @else
                                                <i>@lang('laralum_tickets::general.plain_text')</i>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="uk-margin">
                                        <button type="submit" class="uk-button uk-button-primary">
                                            <span class="ion-forward"></span>&nbsp; @lang('laralum_tickets::general.reply')
                                        </button>
                                    </div>
                                </fieldset>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
