<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClockInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clock_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained('workers')->required();
            $table->timestamp('clock_in_time')->required();
            $table->decimal('latitude')->required();
            $table->decimal('longitude')->required();
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
        Schema::dropIfExists('clock_ins');
    }
}
