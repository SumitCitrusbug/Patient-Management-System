<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timeslots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('docter_id');
            $table->foreign('docter_id')->references('id')->on('docters')->onDelete('cascade');
            $table->date('date');       // 2020-01-01
            $table->time('time_start'); // 15:00:00
            $table->time('time_end');
            $table->boolean('avaliblity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeslots');
    }
};
