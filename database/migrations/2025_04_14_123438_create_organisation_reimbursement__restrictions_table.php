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
            Schema::create('organisation_reimbursement_type_restrictions', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('reimbursement_type_id')->unsigned();
                $table->foreign('reimbursement_type_id')->references('id')->on('organisation_reimbursement_type')->onDelete('cascade');
                $table->decimal('max_amount', 10, 2)->nullable();
                $table->enum('bill_required', ['Yes', 'No'])->default('No');
                $table->enum('tax_applicable', ['Yes', 'No'])->default('No');
                $table->timestamps();
            });
        }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisation_reimbursement__restrictions');
    }
};
