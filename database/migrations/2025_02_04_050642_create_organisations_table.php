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
        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('email',50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile', 15)->unique()->nullable();
            $table->string('building_no',10)->nullable();
            $table->string('premises_name',100)->nullable();
            $table->string('landmark',150)->nullable();
            $table->string('road_street',150)->nullable();
            $table->string('pincode',15)->nullable();
            $table->string('district',50)->nullable();
            $table->string('state',50)->nullable();
            $table->string('country',50)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
