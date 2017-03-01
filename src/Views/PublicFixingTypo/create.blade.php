@extends('laralum::layouts.public')
@section('title', __('laralum_tickets::tickets.create'))
@section('content')
    <form action="{{ route('laralum_public::tickets.index') }}" method="POST">
        {!! csrf_field() !!}
        <label for="subject">@lang('laralum_tickets::general.subject')</label>
        <input id="subject" type="text" name="subject" value="{{ old('subject') }}" class="form-control">
        <br>
        <label for="message">@lang('laralum_tickets::general.message')</label>
        <textarea class="form-control" id="message" name="message" rows="3">{{ old('message') }}</textarea>
        <i>Markdown syntax supported</i>
        <br>
        <a href="{{ route('laralum_public::tickets.index') }}">@lang('laralum::general.cancel')</a>
        <button type="submit">@lang('laralum::general.create')</button>
    </form>
@endsection
