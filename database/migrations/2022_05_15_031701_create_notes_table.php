<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {

            $table->id();
            // $table->string('note_id')->unique()->nullable($value=false);
            $table->string('ticket_id')->nullable($value=false);
            $table->string('note_body')->nullable($value=false);
            $table->string('note_author')->nullable($value=false);
            $table->string('note_type')->nullable($value=false);
            $table->foreign('ticket_id')->references('id_no')->on('tickets')->onDelete('cascade');
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
        Schema::dropIfExists('notes');
    }
}
