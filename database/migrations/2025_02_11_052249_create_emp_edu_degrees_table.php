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
        Schema::create('emp_edu_degrees', function (Blueprint $table) {
            $table->id();
            $table->string('degree',100);
            $table->string('university_board',100);
            $table->string('institution',100);
            $table->string('passing_year',10);
            $table->string('percentage_cgpa',10);
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
        Schema::dropIfExists('emp_edu_degrees');
    }
};
