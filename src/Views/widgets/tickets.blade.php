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
