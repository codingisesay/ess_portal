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
        Schema::create('emp_family_details', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->nullable();
            $table->enum('relation',['Spouce','Child','Parent','Sibiling','Other'])->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender',['Male','Femail','Others'])->nullable();
            $table->string('age',10)->nullable();
            $table->enum('dependent',['Yes','No'])->nullable();
            $table->string('phone_number',15)->nullable();
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
        Schema::dropIfExists('emp_family_details');
    }
};
