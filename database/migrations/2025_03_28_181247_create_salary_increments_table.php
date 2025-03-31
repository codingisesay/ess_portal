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
        Schema::create('salary_increments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->decimal('previous_CTC', 10, 2)->nullable();
            $table->decimal('new_CTC', 10, 2)->nullable();  // Corrected 'deciaml' to 'decimal'
            $table->decimal('increment', 10, 2)->nullable(); // Corrected 'increament' to 'increment'
            
            $table->dateTime('effective_from')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_increments');
    }
};
