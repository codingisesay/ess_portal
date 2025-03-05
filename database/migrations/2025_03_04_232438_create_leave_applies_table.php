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
        Schema::create('leave_applies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('leave_type_id'); 
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');
            $table->datetime('start_date_time')->nullable();
            $table->datetime('end_date_time')->nullable();
            $table->bigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->date('apply_date')->nullable();
            $table->enum('half_day',['Yes','No'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_applies');
    }
};
