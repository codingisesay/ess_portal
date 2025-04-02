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
        Schema::create('org_tax_regime_years', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('cascade');
            $table->string('name');
            $table->datetime('applicable_from');
            $table->datetime('applicable_to');
            $table->enum('status',['Active','Inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_tax_regime_years');
    }
};
