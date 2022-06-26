<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItTrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_train', function (Blueprint $table) {
            $table->id();
            $table->string('tick_id')->nullable($value = false)->unique();
            $table->string('course')->nullable($value = false);
            $table->string('schedule')->nullable($value = false);
            // $table->string('list')->nullable($value = false); // list of courses
            $table->date('start')->nullable($value = false);
            $table->foreign('tick_id')->references('id_no')->on('tickets')->onDelete('cascade');
            // $table->string('issuer')->nullable($value = false);
            // $table->string('client_name')->nullable($value = false);
            // $table->longText('other_info')->nullable();
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
        Schema::dropIfExists('it_train');
    }
}
