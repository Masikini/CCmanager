<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('item_service')->nullable($value = false);
            $table->string('payment_method')->nullable($value = false);
            $table->string('ref')->nullable($value = false)->unique();
            $table->string('description');
            $table->bigInteger('amount')->nullable($value = false);
            $table->string('approved_by')->nullable($value = false);
            $table->string('requested_by')->nullable($value = false);
            $table->string('attach');
            $table->date('date')->nullable($value= false);
            $table->string('category')->nullable($value = false);
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
        Schema::dropIfExists('purchases');
    }
}
