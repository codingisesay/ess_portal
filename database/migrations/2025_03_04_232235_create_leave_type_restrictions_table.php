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
        Schema::create('leave_type_restrictions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('leave_type_id'); 
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');
            $table->string('max_leave',50)->nullable();
            $table->string('max_leave_at_time',50)->nullable();
            $table->string('min_leave_at_time',50)->nullable();
            $table->enum('carry_forward',['Yes','No'])->nullable();
            $table->string('no_carry_forward',50)->nullable();
            $table->enum('leave_encash',['Yes','No'])->nullable();
            $table->string('no_leave_encash',50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_type_restrictions');
    }
};
