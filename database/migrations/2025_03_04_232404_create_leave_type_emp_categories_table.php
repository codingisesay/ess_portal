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
        Schema::create('leave_type_emp_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('leave_restriction_id'); 
            $table->foreign('leave_restriction_id')->references('id')->on('leave_type_restrictions')->onDelete('cascade');
            $table->bigInteger('employee_category_id'); 
            $table->foreign('employee_category_id')->references('id')->on('employee_types')->onDelete('cascade');
            $table->string('leave_count',50)->nullable();
            $table->string('month_start',50)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_type_emp_categories');
    }
};
