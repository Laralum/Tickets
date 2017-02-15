<?php

Route::group([
        'middleware' => ['web', 'laralum.base', 'laralum.auth'],
        'namespace' => 'Laralum\Tickets\Controllers',
        'as' => 'laralum_public::'
    ], function () {
        // First the suplementor, then the resource
        // https://laravel.com/docs/5.4/controllers#resource-controllers

        Route::get('tickets', 'PublicTicketController@tickets')->name('tickets.index');
        Route::get('tickets/create', 'PublicTicketController@createTicket')->name('tickets.create');
        Route::post('tickets/create', 'PublicTicketController@saveTicket');
        Route::post('tickets/close/{ticket}', 'PublicTicketController@closeTicket')->name('tickets.close');
        Route::post('tickets/open/{ticket}', 'PublicTicketController@openTicket')->name('tickets.open');
        Route::get('tickets/show/{ticket}', 'PublicTicketController@showTicket')->name('tickets.show');
        Route::get('tickets/reply/{ticket}', 'PublicTicketController@replyTicket')->name('tickets.reply');
        Route::post('tickets/reply/{ticket}', 'PublicTicketController@saveTicketReply');
});

Route::group([
        'middleware' => ['web', 'laralum.base', 'laralum.auth'],
        'prefix' => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Tickets\Controllers',
        'as' => 'laralum::'
    ], function () {
        // First the suplementor, then the resource
        // https://laravel.com/docs/5.4/controllers#resource-controllers

        Route::get('tickets', 'TicketController@tickets')->name('tickets.index');
        Route::get('tickets/create', 'TicketController@createTicket')->name('tickets.create');
        Route::post('tickets/create', 'TicketController@saveTicket');
        Route::post('tickets/close/{ticket}', 'TicketController@closeTicket')->name('tickets.close');
        Route::post('tickets/open/{ticket}', 'TicketController@openTicket')->name('tickets.open');
        Route::get('tickets/show/{ticket}', 'TicketController@showTicket')->name('tickets.show');
        Route::get('tickets/reply/{ticket}', 'TicketController@replyTicket')->name('tickets.reply');
        Route::post('tickets/reply/{ticket}', 'TicketController@saveTicketReply');
});
