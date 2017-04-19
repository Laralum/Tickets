@if ( \Laralum\Tickets\Models\Ticket::all()->count() <= 0)
    <div style="height: 400px; position: relative;">
        <center>
            @lang('laralum_tickets::general.tickets_status')
        </center>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <center>
                <i class="ion-sad-outline" style="font-size: 100px;"></i><br />
                <span>@lang('laralum_tickets::general.no_data')</span>
            </center>
        </div>
    </div>
@else
    {!!
        \ConsoleTVs\Charts\Facades\Charts::create('pie', 'highcharts')
        ->title( __('laralum_tickets::general.tickets_status') )
        ->colors(['#F44336', '#4CAF50'])
        ->labels([__('laralum_tickets::general.open_tickets'), __('laralum_tickets::general.closed_tickets')])
        ->values([
            \Laralum\Tickets\Models\Ticket::where('open', true)->count(),
            \Laralum\Tickets\Models\Ticket::where('open', false)->count()
        ])
        ->render()
        !!}
@endif
