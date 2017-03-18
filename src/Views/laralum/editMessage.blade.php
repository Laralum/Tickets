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
@section('icon', 'ion-plus-round')
@section('title', __('laralum_tickets::general.edit_message', ['id' => $message->id]))
@section('subtitle', __('laralum_tickets::general.edit_message_desc', ['id' => $message->id]))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_tickets::general.home')</a></li>
        <li><a href="{{ route('laralum::tickets.index') }}">@lang('laralum_tickets::general.ticket_list')</a></li>
        <li><span>@lang('laralum_tickets::general.edit_message', ['id' => $message->id])</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-1-1@s uk-width-1-6@l uk-width-1-5@xl"></div>
            <div class="uk-width-1-1@s uk-width-4-6@l uk-width-3-5@xl">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        @lang('laralum_tickets::general.edit_message', ['id' => $message->id])
                    </div>
                    <div class="uk-card-body">
                        <form method="POST" action="{{ route('laralum::tickets.messages.update',['message' => $message->id]) }}">
                            {{ csrf_field() }}
                            <fieldset class="uk-fieldset">
                                <div class="uk-margin">
                                    @if ($settings->text_editor == 'wysiwyg')
                                        <textarea name="message">
                                            {{ old('message', $message->message) }}
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
                                        <span class="ion-forward"></span>&nbsp; @lang('laralum_tickets::general.edit')
                                    </button>
                                </div>
                            </fieldset>
                        </form>

                    </div>
                </div>
            </div>
            <div class="uk-width-1-1@s uk-width-1-6@l uk-width-1-5@xl"></div>
        </div>
    </div>

@endsection
