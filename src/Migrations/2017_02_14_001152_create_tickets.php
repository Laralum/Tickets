<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laralum_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('creator'); // User or Admin
            $table->integer('user_id'); // User which create ticket
            $table->integer('admin_id'); // Admin which will solve ticket
            $table->string('subject');
            $table->text('description');
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
        Schema::dropIfExists('laralum_tickets');
    }
}
