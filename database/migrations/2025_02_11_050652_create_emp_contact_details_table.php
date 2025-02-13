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
        Schema::create('emp_contact_details', function (Blueprint $table) {
            $table->id();
            $table->string('per_building_no',50)->nullable();
            $table->string('per_name_of_premises',50)->nullable();;
            $table->string('per_nearby_landmark',50)->nullable();;
            $table->string('per_road_street',50)->nullable();;
            $table->string('per_country',50)->nullable();;
            $table->string('per_pincode',10)->nullable();;
            $table->string('per_district',50)->nullable();;
            $table->string('per_city',50)->nullable();;
            $table->string('per_state',50)->nullable();;
            $table->string('cor_building_no',50)->nullable();;
            $table->string('cor_name_of_premises',50)->nullable();;
            $table->string('cor_nearby_landmark',50)->nullable();;
            $table->string('cor_road_street',50)->nullable();;
            $table->string('cor_country',50)->nullable();;
            $table->string('cor_pincode',50)->nullable();;
            $table->string('cor_district',50)->nullable();;
            $table->string('cor_city',50)->nullable();;
            $table->string('cor_state',50)->nullable();;
            $table->string('offical_phone_number',15)->nullable();;
            $table->string('alternate_phone_number',15)->nullable();;
            $table->string('email_address',100)->nullable();;
            $table->string('offical_email_address',100)->nullable();;
            $table->string('emergency_contact_person',50)->nullable();;
            $table->string('emergency_contact_number',50)->nullable();;
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
        Schema::dropIfExists('emp_contact_details');
    }
};
