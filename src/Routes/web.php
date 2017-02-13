<?php

Route::group([
        'middleware' => ['web', 'laralum.base', 'laralum.auth'],
        'namespace' => 'Laralum\Tickets\Controllers',
        'as' => 'laralum_public::'
    ], function () {
        // First the suplementor, then the resource
        // https://laravel.com/docs/5.4/controllers#resource-controllers

        Route::get('tickets', 'TicketsController@publicTickets')->name('tickets.index');
        Route::get('tickets/create', 'TicketsController@publicCreateTicket')->name('tickets.create');
        Route::post('tickets/create', 'TicketsController@saveTicket');
});

Route::group([
        'middleware' => ['web', 'laralum.base', 'laralum.auth'],
        'prefix' => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Tickets\Controllers',
        'as' => 'laralum::'
    ], function () {
        // First the suplementor, then the resource
        // https://laravel.com/docs/5.4/controllers#resource-controllers

        Route::get('tickets', 'TicketsController@tickets')->name('tickets.index');
        Route::get('tickets/create', 'TicketsController@createTickets')->name('tickets.create');
        Route::post('tickets/create', 'TicketsController@saveTicket');
});
