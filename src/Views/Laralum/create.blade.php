@extends('laralum::layouts.master')
@section('icon', 'mdi-tag-plus')
@section('title', trans('laralum_tickets::tickets.create'))
@section('subtitle', trans('laralum_tickets::tickets.tickets_create_desc'))
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-8 offset-lg-2">
            <div class="card shadow">
                <div class="card-header">
                    @lang('laralum_tickets::tickets.create')
                </div>
                <div class="card-block">
                    <form action="{{route('laralum::tickets.index')}}" method="POST">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label for="email">@lang('laralum_tickets::tickets.user_email')</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="subject">@lang('laralum::general.subject')</label>
                            <input id="subject" type="text" name="subject" value="{{ old('subject') }}" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="message">@lang('laralum_tickets::tickets.message')</label>
                          <textarea class="form-control" id="message" name="message" rows="3">{{ old('message') }}</textarea>
                        </div>
                        <a href="{{route('laralum::tickets.index')}}" class="btn btn-warning float-left">@lang('laralum::general.cancel')</a>
                        <button type="submit" class="btn btn-success float-right clickable">@lang('laralum::general.create')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
