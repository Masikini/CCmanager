<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable($value = false);
            $table->string('id_type')->nullable($value = true);
            $table->string('id_no')->nullable()->unique($value = false);
            $table->string('email')->nullable($value = true);
            $table->bigInteger('phone')->nullable($value = false)->unique();
            $table->string('residence')->nullable($value = false);
            $table->string('institution')->nullable($value = true);
            $table->enum('age', ['0-17', '18-29', '30+']);
            $table->enum('gender', ['F', 'M','O']);

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
        Schema::dropIfExists('clients');
    }
}
