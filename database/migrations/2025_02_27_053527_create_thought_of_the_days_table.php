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
        Schema::create('thought_of_the_days', function (Blueprint $table) {
            $table->id();
            $table->date('creationDate')->nullable();
            $table->string('thought');
            $table->unsignedBigInteger('organisation_id'); 
            $table->foreign('organisation_id')->references('id')->on('organisation')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thought_of_the_days');
    }
};
