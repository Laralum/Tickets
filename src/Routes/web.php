<?php


Route::group([
        'middleware' => [
            'web', 'laralum.base', 'auth',
            'can:publicAccess,Laralum\Tickets\Models\Ticket',
        ],
        'namespace' => 'Laralum\Tickets\Controllers',
        'as' => 'laralum_public::'
    ], function () {
        if (\Illuminate\Support\Facades\Schema::hasTable('laralum_tickets_settings')) {
            $public_url = \Laralum\Tickets\Models\Settings::first()->public_url;
        } else {
            $public_url = 'tickets';
        }
        Route::post($public_url.'/close/{ticket}', 'PublicTicketController@close')->name('tickets.close');
        Route::post($public_url.'/open/{ticket}', 'PublicTicketController@open')->name('tickets.open');
        Route::post($public_url.'/reply/{ticket}', 'PublicTicketController@reply')->name('tickets.reply');
        Route::resource($public_url, 'PublicTicketController', ['names' => [
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
