<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {


            // $table->id();
            // $table->string('payment_method')->nullable($value = false);
            // $table->string('ref')->nullable($value = false);
            // $table->string('description');
            // // $table->string('promo_code');
            // $table->bigInteger('amount')->nullable($value = false);
            // $table->string('tick_id')->nullable($value = false)->unique();
            // $table->foreign('tick_id')->references('id_no')->on('tickets')->onDelete('cascade');
            // // $table->foreign('promo_code')->references('promo_code')->on('campaigns');
            // $table->timestamps();

            $table->id();
            $table->string('tick_id')->nullable($value = false);
            $table->string('payment_method')->nullable($value = false);
            $table->string('description')->nullable();
            $table->string('attach')->nullable();
            $table->bigInteger('amount')->nullable($value = false);
            $table->string('ref')->nullable($value = false);
            $table->foreign('tick_id')->references('id_no')->on('tickets')->onDelete('cascade');
   
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
        Schema::dropIfExists('sales');
    }
}
