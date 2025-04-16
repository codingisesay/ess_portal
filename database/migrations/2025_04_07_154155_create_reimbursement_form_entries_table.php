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
        Schema::create('reimbursement_form_entries', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->bigInteger('reimbursement_trackings_id')->unsigned(); 
            $table->foreign('reimbursement_trackings_id')->references('id')->on('reimbursement_trackings')->onDelete('cascade');
            $table->bigInteger('organisation_reimbursement_types_id')->unsigned(); 
            $table->foreign('organisation_reimbursement_types_id')->references('id')->on('organisation_reimbursement_types')->onDelete('cascade');
            $table->decimal('amount', 10,2)->nullable();
            $table->string('upload_bill')->nullable();
            $table->text('description_by_applicant')->nullable();
            $table->text('description_by_manager')->nullable();
            $table->text('description_by_finance')->nullable();
            $table->enum('status',['Approved','Reject','Review'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimbursement_form_entries');
    }
};
