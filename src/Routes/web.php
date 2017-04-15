<?php


if (\Illuminate\Support\Facades\Schema::hasTable('laralum_tickets_settings')) {
    $public_url = \Laralum\Tickets\Models\Settings::first()->public_url;
} else {
    $public_url = 'tickets';
}

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'auth',
            'can:publicAccess,Laralum\Tickets\Models\Ticket',
        ],
        'namespace' => 'Laralum\Tickets\Controllers',
        'as'        => 'laralum_public::tickets.',
    ], function () use ($public_url) {
        Route::post($public_url.'/close/{ticket}', 'PublicTicketController@close')->name('close');
        Route::post($public_url.'/open/{ticket}', 'PublicTicketController@open')->name('open');

        // Passing the ticket_id of the message
        Route::post($public_url.'/messages/{ticket}', 'PublicMessageController@store')->name('messages.store');
        Route::get($public_url.'/messages/{message}/edit', 'PublicMessageController@edit')->name('messages.edit');
        Route::patch($public_url.'/messages/{message}/update', 'PublicMessageController@update')->name('messages.update');
        Route::get($public_url.'/messages/{message}/delete', 'PublicMessageController@confirmDestroy')->name('messages.destroy.confirm');
        Route::delete($public_url.'/messages/{message}/delete', 'PublicMessageController@destroy')->name('messages.destroy');

        Route::resource($public_url, 'PublicTicketController', ['names' => [
            'index'   => 'index',
            'create'  => 'create',
            'store'   => 'store',
            'show'    => 'show',
            'edit'    => 'edit',
            'update'  => 'update',
            'destroy' => 'destroy',
        ]]);
    });

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            'can:access,Laralum\Tickets\Models\Ticket',
        ],
        'prefix'    => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Tickets\Controllers',
        'as'        => 'laralum::',
    ], function () {
        Route::post('tickets/settings', 'SettingsController@update')->name('tickets.settings.update');

        Route::post('tickets/close/{ticket}', 'TicketController@close')->name('tickets.close');
        Route::post('tickets/open/{ticket}', 'TicketController@open')->name('tickets.open');
        Route::get('tickets/delete/{ticket}', 'TicketController@confirmDestroy')->name('tickets.destroy.confirm');

        // Passing the ticket_id of the message
        Route::post('tickets/messages/{ticket}', 'MessageController@store')->name('tickets.messages.store');
        Route::get('tickets/messages/{message}/edit', 'MessageController@edit')->name('tickets.messages.edit');
        Route::patch('tickets/messages/{message}/update', 'MessageController@update')->name('tickets.messages.update');
        Route::get('tickets/messages/{message}/delete', 'MessageController@confirmDestroy')->name('tickets.messages.destroy.confirm');
        Route::delete('tickets/messages/{message}/delete', 'MessageController@destroy')->name('tickets.messages.destroy');

        Route::resource('messages', 'TicketController');
        Route::resource('tickets', 'TicketController');
    });
