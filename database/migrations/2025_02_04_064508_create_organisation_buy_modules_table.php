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
        Schema::create('organisation_buy_modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id'); 
            $table->foreign('module_id')->references('id')->on('module')->onDelete('cascade');
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
        Schema::dropIfExists('organisation_buy_modules');
    }
};
