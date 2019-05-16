<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_id');
            $table->string('invoice_code', 191);
            $table->integer('room_number');
            $table->integer('price');
            $table->date('check_in_date');
            $table->date('check_out_date');
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
        Schema::dropIfExists('room_invoice');
    }
}
