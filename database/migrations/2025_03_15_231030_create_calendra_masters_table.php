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
        Schema::create('calendra_masters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('organisation_id'); 
            $table->foreign('organisation_id')->references('id')->on('organisation')->onDelete('cascade');
            $table->string('year',10)->nullable();
            $table->date('date')->nullable();
            $table->string('day',10)->nullable();
            $table->enum('week_off',['Yes','No'])->default('No');
            $table->enum('holiday',['Yes','No'])->default('No');
            $table->string('holiday_desc')->nullable();
            $table->time('working_start_time')->nullable();
            $table->time('working_end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendra_masters');
    }
};
