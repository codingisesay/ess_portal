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
        Schema::create('emp_edu_certificats', function (Blueprint $table) {
            $table->id();
            $table->string('certification_name',100);
            $table->string('marks_obtained',100);
            $table->string('out_of_marks_total_marks',100);
            $table->string('date_of_certificate',100);
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
        Schema::dropIfExists('emp_edu_certificats');
    }
};
