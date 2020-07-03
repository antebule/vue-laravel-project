<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThesisReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thesis_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // $table->date('date');
            $table->string('status');
            $table->timestamps();

            $table->foreignId('user_id')->constrained();
            $table->foreignId('teacher_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thesis_reservations');
    }
}
