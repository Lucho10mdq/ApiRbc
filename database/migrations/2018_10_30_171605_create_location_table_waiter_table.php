<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationTableWaiterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_table_waiter', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_table_id')->unsigned();
            $table->integer('waiter_id')->unsigned();
            $table->timestamps();

            $table->foreign('location_table_id')->references('id')->on('locations_tables');
            $table->foreign('waiter_id')->references('id')->on('waiters');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_table_waiter');
    }
}
