<?php


Route::group([
        'middleware' => [
            'web', 'laralum.base', 'auth',
            'can:publicAccess,Laralum\Tickets\Models\Ticket',
        ],
        'namespace' => 'Laralum\Tickets\Controllers',
        'as' => 'laralum_public::'
    ], function () {
        $settings = \Laralum\Tickets\Models\Settings::first();
        Route::post($settings->public_url.'/close/{ticket}', 'PublicTicketController@close')->name('tickets.close');
        Route::post($settings->public_url.'/open/{ticket}', 'PublicTicketController@open')->name('tickets.open');
        Route::post($settings->public_url.'/reply/{ticket}', 'PublicTicketController@reply')->name('tickets.reply');
        Route::resource($settings->public_url, 'PublicTicketController', ['names' => [
            'index' => 'tickets.index',
            'create' => 'tickets.create',
            'store' => 'tickets.store',
            'show' => 'tickets.show',
            'edit' => 'tickets.update',
            'update' => 'tickets.update',
            'destroy' => 'tickets.destroy',
        ]]);
});

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            'can:access,Laralum\Tickets\Models\Ticket',
        ],
        'prefix' => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Tickets\Controllers',
        'as' => 'laralum::'
    ], function () {
        Route::post('tickets/settings', 'TicketController@updateSettings')->name('tickets.settings.update');
        Route::post('tickets/close/{ticket}', 'TicketController@close')->name('tickets.close');
        Route::post('tickets/open/{ticket}', 'TicketController@open')->name('tickets.open');
        Route::post('tickets/reply/{ticket}', 'TicketController@reply')->name('tickets.reply');
        Route::get('tickets/delete/{ticket}', 'TicketController@confirmDestroy')->name('tickets.destroy.confirm');
        Route::get('tickets/messages/edit/{message}', 'TicketController@editMessage')->name('tickets.messages.edit');
        Route::post('tickets/messages/edit/{message}', 'TicketController@updateMessage')->name('tickets.messages.update');
        Route::get('tickets/messages/delete/{message}', 'TicketController@confirmMessageDestroy')->name('tickets.messages.destroy.confirm');
        Route::post('tickets/messages/delete/{message}', 'TicketController@messageDestroy')->name('tickets.messages.destroy');
        Route::resource('tickets', 'TicketController');
});
