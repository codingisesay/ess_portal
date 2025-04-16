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
        Schema::create('assign_reimbursement_tokens', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->bigInteger('reimbursement_tracking_id'); 
            $table->foreign('reimbursement_tracking_id')->references('id')->on('reimbursement_trackings')->onDelete('cascade');
            $table->text('comments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_reimbursement_tokens');
    }
};
