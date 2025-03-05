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
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();
            $table->enum('half_day',['Yes','No'])->nullable();
            $table->enum('status',['Active','Inactive'])->nullable();
            $table->bigInteger('leave_cycle_id'); 
            $table->foreign('leave_cycle_id')->references('id')->on('leave_cycles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
