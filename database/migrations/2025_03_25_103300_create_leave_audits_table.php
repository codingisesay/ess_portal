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
        Schema::create('leave_audits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('leave_cycle_id'); 
            $table->foreign('leave_cycle_id')->references('id')->on('leave_cycles')->onDelete('cascade');
            $table->bigInteger('leave_policy_id'); 
            $table->foreign('leave_policy_id')->references('id')->on('leave_types')->onDelete('cascade');
            $table->decimal('carry_forward', 8, 2);
            $table->decimal('leave_encash', 8, 2);
            $table->decimal('lop', 8, 2);
            $table->decimal('leave_laps', 8, 2);
            $table->bigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_audits');
    }
};
