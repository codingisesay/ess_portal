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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organisation_id'); 
            $table->foreign('organisation_id')->references('id')->on('organisation')->onDelete('cascade');
            $table->string('name',50);
            $table->string('mobile',15);
            $table->string('branch_email',50);
            $table->string('building_no',50)->nullable();
            $table->string('premises_name',50)->nullable();
            $table->string('landmark',100)->nullable();
            $table->string('road_street',100)->nullable();
            $table->string('pincode',10)->nullable();
            $table->string('district',100)->nullable();
            $table->string('state',100)->nullable();
            $table->string('country',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
