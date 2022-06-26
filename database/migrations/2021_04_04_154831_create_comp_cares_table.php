<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompCaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comp_care', function (Blueprint $table) {
         
            $table->id();
            $table->string('tick_id')->nullable($value = false)->unique();
            $table->string('service')->nullable($value = false);
            // $table->string('issuer');
            // $table->string('handler')->nullable();
            // $table->string('status')->default('open');
            // $table->string('client_name')->nullable($value = false);
            // $table->longText('description')->nullable();
            $table->string('incidents')->nullable();
            $table->string('item_brand')->nullable();
            $table->string('item_model')->nullable();
            $table->string('item_sn')->nullable();
           
            $table->timestamps();
            $table->foreign('tick_id')->references('id_no')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comp_care');
    }
}
