<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaralumTicketsMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laralum_tickets_messages', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('ticket_id');
			$table->integer('user_id');
			$table->text('message');
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::drop('laralum_tickets_messages');
    }
}
