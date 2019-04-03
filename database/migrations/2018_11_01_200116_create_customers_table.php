<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id') ;
            $table->string('contact',50)->nullable() ;
            $table->string('contact_phone',50)->nullable() ;
            $table->integer('people_id')->unsigned() ;
            $table->timestamps() ;
            $table->foreign('people_id')->references('id')->on('people') ;
            $table->softDeletes() ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
