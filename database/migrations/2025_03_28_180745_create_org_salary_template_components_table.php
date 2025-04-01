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
        Schema::create('org_salary_template_components', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('salary_template_id')->unsigned();
            $table->foreign('salary_template_id')->references('id')->on('org_salary_templates')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->enum('type',['Earning','Deduction']);
            $table->enum('calculation_type',['Percentage','Fixed'])->nullable();
            $table->decimal('value', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_salary_template_components');
    }
};
