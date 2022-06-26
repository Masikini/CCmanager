<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable($value = false);
            $table->string('category')->nullable($value = false);
            $table->string('facilitator')->nullable($value = false);
            $table->string('description');
            $table->bigInteger('target')->nullable($value = false);
            $table->bigInteger('engaged')->default('0');
            $table->bigInteger('acquired')->default('0');
            $table->date('start');
            $table->date('end')->nullable($value= false);
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
        Schema::dropIfExists('campaigns');
    }
}
