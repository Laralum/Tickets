@extends('laralum::layouts.master')
@section('icon', 'mdi-tag-plus')
@section('title', trans('laralum_tickets::tickets.reply_ticket'))
@section('subtitle', trans('laralum_tickets::tickets.tickets_reply_desc'))
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-8 offset-lg-2">
            <div class="card shadow">
                <div class="card-header">
                    @lang('laralum_tickets::tickets.reply_ticket')
                </div>
                <div class="card-block">
                    <form method="POST" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group">
                          <label for="message">@lang('laralum_tickets::tickets.message')</label>
                          <textarea class="form-control" id="message" name="message" rows="3">{{ old('message') }}</textarea>
                        </div>
                        <a href="{{route('laralum::tickets.show',['ticket' => $ticket->id])}}" class="btn btn-warning float-left">@lang('laralum::general.cancel')</a>
                        <button type="submit" class="btn btn-success float-right clickable">@lang('laralum::general.create')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
