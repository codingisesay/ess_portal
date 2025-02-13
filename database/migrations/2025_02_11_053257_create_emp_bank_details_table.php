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
        Schema::create('emp_bank_details', function (Blueprint $table) {
            $table->id();
            // $table->string('per_bank_name',100); //fk
            $table->bigInteger('per_bank_name'); 
            $table->foreign('per_bank_name')->references('id')->on('bank')->onDelete('cascade');
            $table->string('per_branch_name',100);
            $table->string('per_account_number',50);
            $table->string('per_ifsc_code',20);
            // $table->string('sal_bank_name',20); //fk
            $table->bigInteger('sal_bank_name'); 
            $table->foreign('sal_bank_name')->references('id')->on('bank')->onDelete('cascade');
            $table->string('sal_branch_name',100);
            $table->string('sal_account_number',50);
            $table->string('sal_ifsc_code',20);
            $table->string('passport_number',100);
            $table->string('issuing_country',50);
            $table->date('passport_issue_date');
            $table->date('passport_expiry_date');
            $table->enum('active_visa',['Yes','No']);
            $table->date('visa_expiry_date');
            $table->enum('vehicle_type',['Car','Bike']);
            $table->string('vehicle_model',50);
            $table->string('vehicle_owner',50);
            $table->string('vehicle_number',50);
            $table->string('insurance_provider',50);
            $table->date('insurance_expiry_date');
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
        Schema::dropIfExists('emp_bank_details');
    }
};
