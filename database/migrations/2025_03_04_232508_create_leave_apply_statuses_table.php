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
        Schema::create('leave_apply_statuses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('leave_apply_id'); 
            $table->foreign('leave_apply_id')->references('id')->on('leave_applies')->onDelete('cascade');
            $table->enum('leave_approve_status',['Approved','Pending','Reject'])->nullable();
            $table->bigInteger('status_updated_by'); 
            $table->foreign('status_updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('status_update_date_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_apply_statuses');
    }
};
