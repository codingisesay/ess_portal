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
        Schema::create('emp_previous_employments', function (Blueprint $table) {
            $table->id();
            $table->string('employer_name',50);
            $table->string('country',50);
            $table->string('city',50);
            $table->date('from_date');
            $table->date('to_date');
            $table->string('designation');
            $table->string('last_drawn_annual_salary',50);
            $table->string('relevant_experience',50);
            $table->string('reason_for_leaving',100);
            $table->string('major_responsibilities',100);
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
        Schema::dropIfExists('emp_previous_employments');
    }
};
