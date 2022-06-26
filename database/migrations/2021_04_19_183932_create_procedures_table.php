<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedures', function (Blueprint $table) {

            $table->id();
            $table->string('tick_id')->nullable($value = false);
            $table->longText('change')->nullable();
            // $table->string('carrier_id')->nullable($value = false);
            $table->longText('summary')->nullable();
            $table->foreign('tick_id')->references('id_no')->on('tickets')->onDelete('cascade');
            $table->string('carrier_id')->nullable();
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
        Schema::dropIfExists('procedures');
    }
}
