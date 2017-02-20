<?php

Route::group([
        'middleware' => ['web', 'laralum.base', 'auth'],
        'namespace' => 'Laralum\Tickets\Controllers',
        'as' => 'laralum_public::'
    ], function () {
        Route::post('tickets/close/{ticket}', 'PublicTicketController@close')->name('tickets.close');
        Route::post('tickets/open/{ticket}', 'PublicTicketController@open')->name('tickets.open');
        Route::post('tickets/reply/{ticket}', 'PublicTicketController@reply')->name('tickets.reply');
        Route::resource('tickets', 'PublicTicketController', ['only' => [
            'index', 'create', 'store', 'show'
        ]]);
});

Route::group([
        'middleware' => ['web', 'laralum.base', 'laralum.auth'],
        'prefix' => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Tickets\Controllers',
        'as' => 'laralum::'
    ], function () {
        Route::post('tickets/close/{ticket}', 'TicketController@close')->name('tickets.close');
        Route::post('tickets/open/{ticket}', 'TicketController@open')->name('tickets.open');
        Route::post('tickets/reply/{ticket}', 'TicketController@reply')->name('tickets.reply');
        Route::resource('tickets', 'TicketController', ['only' => [
            'index', 'create', 'store', 'show'
        ]]);
});
