@extends('laralum::layouts.master')
@section('icon', 'mdi-tag-multiple')
@section('title', trans('laralum_tickets::tickets.tickets'))
@section('subtitle', trans('laralum_tickets::tickets.tickets_desc'))
@section('content')
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#opened" role="tab">@lang('laralum_tickets::tickets.opened_tickets')</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#closed" role="tab">@lang('laralum_tickets::tickets.closed_tickets')</a>
  </li>
</ul>
<br>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="opened" role="tabpanel">
      <div class="row">
          @if ($openedTickets->count()<1)
              <div class="col-md-12 col-lg-8 offset-lg-2">
                  <center>
                      <br /><br />
                      <h3>@lang('laralum_tickets::tickets.no_opened_tickets')</h3>
                      <h1 class="mdi mdi-emoticon-sad"></h1>
                      <br />
                  </center>
              </div>
          @else
              <h5>Tickets list</h5><br />
              <div class="table-responsive">
                  <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>@lang('laralum_tickets::tickets.subject')</th>
                              <th>@lang('laralum::general.user')</th>
                              <th>@lang('laralum_tickets::tickets.messages')</th>
                              <th>@lang('laralum::general.actions')</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($openedTickets as $ticket)
                              <tr>
                                  <th>{{$ticket->id}}</th>
                                  <td>
                                      <a href="{{route('laralum::tickets.show',['ticket' => $ticket->id])}}" data-toggle="tooltip" data-placement="top" title="{{trans('laralum_tickets::tickets.show_ticket',['id' => '#'.$ticket->id])}}">
                                          {{$ticket->subject}}
                                      </a>
                                  </td>
                                  <td>{{Laralum\Users\Models\User::findOrFail($ticket->user_id)->email}}</td>
                                  <td>{{$ticket->messages()->count()}}</td>
                                  <td>
                                          <form action="{{route('laralum::tickets.close',['ticket' => $ticket->id])}}"  method="post">
                                              {{ csrf_field() }}
                                              <button type="submit" class="btn btn-danger btn-sm clickable" data-toggle="tooltip" data-placement="top" title="{{trans('laralum_tickets::tickets.close_ticket',['id' => '#'.$ticket->id])}}"><i class="mdi mdi-inbox-arrow-down"></i></button>
                                          </form>

                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          @endif
      </div>
  </div>
  <div class="tab-pane" id="closed" role="tabpanel">
      <div class="row">
          @if ($closedTickets->count()<1)
              <div class="col-md-12 col-lg-8 offset-lg-2">
                  <center>
                      <br /><br />
                      <h3>@lang('laralum_tickets::tickets.no_opened_tickets')</h3>
                      <h1 class="mdi mdi-emoticon-sad"></h1>
                      <br />
                  </center>
              </div>
          @else
              <h5>Closed tickets list</h5><br />
              <div class="table-responsive">
                  <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>@lang('laralum_tickets::tickets.subject')</th>
                              <th>@lang('laralum::general.user')</th>
                              <th>@lang('laralum_tickets::tickets.messages')</th>
                              <th>@lang('laralum::general.actions')</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($closedTickets as $ticket)
                              <tr>
                                  <th>{{$ticket->id}}</th>
                                  <td>
                                      <a href="{{route('laralum::tickets.show',['ticket' => $ticket->id])}}" data-toggle="tooltip" data-placement="top" title="{{trans('laralum_tickets::tickets.show_ticket',['id' => '#'.$ticket->id])}}">
                                          {{$ticket->subject}}
                                      </a>
                                  </td>
                                  <td>{{Laralum\Users\Models\User::findOrFail($ticket->user_id)->email}}</td>
                                  <td>{{$ticket->messages()->count()}}</td>
                                  <td>
                                          <form action="{{route('laralum::tickets.open',['ticket' => $ticket->id])}}"  method="post">
                                              {{ csrf_field() }}
                                              <button type="submit" class="btn btn-success btn-sm clickable" data-toggle="tooltip" data-placement="top" title="{{trans('laralum_tickets::tickets.reopen_ticket',['id' => '#'.$ticket->id])}}"><i class="mdi mdi-inbox-arrow-up"></i></button>
                                          </form>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          @endif
      </div>
  </div>
</div>
@endsection
