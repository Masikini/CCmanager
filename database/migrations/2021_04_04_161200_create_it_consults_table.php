<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItConsultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_consult', function (Blueprint $table) {
            $table->id();
            $table->string('tick_id')->nullable($value = false)->unique();
            $table->string('service')->nullable($value = false);
            $table->foreign('tick_id')->references('id_no')->on('tickets')->onDelete('cascade');
            // $table->string('institution')->nullable();
            // $table->string('address')->nullable();
            // $table->string('issuer')->nullable($value = false);
            // $table->string('rep_name')->nullable($value = false);
            // $table->string('rep_phone')->nullable($value = false);
            // $table->string('rep_designation')->nullable($value = false);
            // $table->string('rep_mail')->nullable();
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
        Schema::dropIfExists('it_consult');
    }
}
