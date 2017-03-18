<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Laralum\Tickets\Models\Settings;

class CreateLaralumTicketsSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laralum_tickets_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text_editor');
            $table->string('public_url');
            $table->timestamps();
        });

        Settings::create([
            'text_editor' => "markdown",
            'public_url' => "tickets",
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laralum_tickets_settings');
    }
}
