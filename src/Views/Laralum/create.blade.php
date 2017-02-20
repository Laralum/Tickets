@extends('laralum::layouts.master')
@section('icon', 'ion-plus-round')
@section('title', trans('laralum_tickets::general.create_ticket'))
@section('subtitle', trans('laralum_tickets::general.tickets_create_desc'))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_tickets::general.home')</a></li>
        <li><a href="{{ route('laralum::tickets.index') }}">@lang('laralum_tickets::general.ticket_list')</a></li>
        <li><span>@lang('laralum_tickets::general.create_ticket')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
            <div class="uk-width-1-1@s uk-width-3-5@l uk-width-1-3@xl">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        @lang('laralum_tickets::general.create_ticket')
                    </div>
                    <div class="uk-card-body">
                        <form method="POST" action="{{ route('laralum::tickets.index') }}">
                            {{ csrf_field() }}
                            <fieldset class="uk-fieldset">


                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_tickets::general.user_email')</label>
                                    <input value="{{ old('email') }}" name="email" class="uk-input" type="email" placeholder="@lang('laralum_tickets::general.user_email')">

                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_tickets::general.subject')</label>
                                    <input value="{{ old('subject') }}" name="subject" class="uk-input" type="text" placeholder="@lang('laralum_tickets::general.subject')">
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_tickets::general.message')</label>
                                    <textarea name="message" class="uk-textarea" rows="5" placeholder="@lang('laralum_tickets::general.message')">{{ old('message') }}</textarea>
                                    <i>@lang('laralum_tickets::general.mkdown_supported')</i>
                                </div>

                                <div class="uk-margin">
                                    <button type="submit" class="uk-button uk-button-primary uk-align-right">
                                        <span class="ion-forward"></span>&nbsp; @lang('laralum::general.create')
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
        </div>
    </div>

@endsection
