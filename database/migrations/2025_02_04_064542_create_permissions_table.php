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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organisation_designations_id'); 
            $table->foreign('organisation_designations_id')->references('id')->on('organisation_designations')->onDelete('cascade');
            $table->unsignedBigInteger('feature_id'); 
            $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id'); 
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('organisation_id'); 
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
