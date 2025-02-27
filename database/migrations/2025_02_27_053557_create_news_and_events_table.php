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
        Schema::create('news_and_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organisation_id'); 
            $table->foreign('organisation_id')->references('id')->on('organisation')->onDelete('cascade');
            $table->date('creationDate')->nullable();
            $table->string('title',100);
            $table->string('description');
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->string('location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_and_events');
    }
};
