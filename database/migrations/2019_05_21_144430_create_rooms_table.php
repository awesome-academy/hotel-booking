<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id');
            $table->text('image');
            $table->integer('sale_status')->default(0);
            $table->date('sale_start_at')->nullable();
            $table->date('sale_end_at')->nullable();
            $table->text('list_room_number');
            $table->string('rating', 5);
            $table->longText('available_time');
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
        Schema::dropIfExists('rooms');
    }
}
