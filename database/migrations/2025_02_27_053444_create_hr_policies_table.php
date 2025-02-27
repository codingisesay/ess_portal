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
        Schema::create('hr_policies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('policy_categorie_id');
            $table->foreign('policy_categorie_id')->references('id')->on('hr_policy_categories')->onDelete('cascade');
            $table->string('policy_title',50)->nullable();
            $table->string('policy_content')->nullable();
            $table->string('docName',100)->nullable();
            $table->string('docLink')->nullable();
            $table->string('iconName',100)->nullable();
            $table->string('iconLink')->nullable();
            $table->string('imgName',100)->nullable();
            $table->string('imgLink')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_policies');
    }
};
