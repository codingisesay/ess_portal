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
        Schema::create('org_tax_slabs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('cascade');
            $table->enum('tax_type',['Income Tax'])->nullable();
            $table->decimal('min_income', 10 , 2);
            $table->decimal('max_income', 10 , 2);
            $table->decimal('tax', 10 , 2);
            $table->decimal('fixed_amount', 10 , 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_tax_slabs');
    }
};
