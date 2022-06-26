<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            // $table->engine = 'InnoDB';
            // $table->string('id');
            // $table->primary('id');
            $table->id();
            $table->string('id_no')->unique()->nullable($value=false);
            $table->string('service')->nullable($value = false);
            $table->string('issuer');
            $table->string('handler')->nullable();
            $table->string('list')->nullable($value = false); // list of services
            $table->string('status')->default('open');
            $table->string('client_id');
            // $table->string('client_id')->nullable($value = false);
            $table->longText('description')->nullable();
            // $table->foreign('client_id')->references('id_no')->on('tickets')->onDelete('cascade');
            $table->string('user_id')->nullable();
            $table->bigInteger('cost')->nullable($value = false);
            $table->bigInteger('paid')->nullable($value = false)->default(0);
            $table->longText('costs_metadata')->nullable();
            $table->longText('campaign_title')->nullable($value=true);
            // $table->string('incidents')->nullable();
            // $table->string('item_brand')->nullable();
            // $table->string('item_model')->nullable();
            // $table->string('item_sn')->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
