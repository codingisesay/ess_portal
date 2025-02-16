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
        Schema::create('emp_educations', function (Blueprint $table) {
            $table->id();
            $table->string('course_type',50)->nullable();
            $table->string('degree',100)->nullable();
            $table->string('university_board',100)->nullable();
            $table->string('institution',100)->nullable();
            $table->string('passing_year',10)->nullable();
            $table->string('percentage_cgpa',10)->nullable();
            $table->string('certification_name',100)->nullable();
            $table->string('marks_obtained',100)->nullable();
            $table->string('out_of_marks_total_marks',100)->nullable();
            $table->string('date_of_certificate',100)->nullable();
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
        Schema::dropIfExists('emp_educations');
    }
};
