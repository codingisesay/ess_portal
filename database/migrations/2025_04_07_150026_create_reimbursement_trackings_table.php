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
        Schema::create('reimbursement_trackings', function (Blueprint $table) {
            $table->id();
            $table->string('token_number')->nullable();
            $table->enum('status',['Pending','Approved','Reject','Cash Transfer','Review'])->nullable();
            $table->bigInteger('assign_to'); 
            $table->foreign('assign_to')->references('id')->on('user')->onDelete('cascade');
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
        Schema::dropIfExists('reimbursement_trackings');
    }
};
