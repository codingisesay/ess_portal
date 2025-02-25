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
//         MAIL_MAILER=smtp
// MAIL_HOST=smtp.office365.com
// MAIL_PORT=587
// MAIL_USERNAME=akashsngh681681@outlook.com
// MAIL_PASSWORD=Password_1993singh
// MAIL_ENCRYPTION=tls
// MAIL_FROM_ADDRESS="akashsngh681681@outlook.com"
// MAIL_FROM_NAME="${APP_NAME}"
        Schema::create('organisation_config_mails', function (Blueprint $table) {
            $table->id();
            $table->string('MAIL_MAILER',50);
            $table->string('MAIL_HOST',50);
            $table->string('MAIL_PORT',10);
            $table->string('MAIL_USERNAME',50);
            $table->string('MAIL_PASSWORD',50);
            $table->string('MAIL_ENCRYPTION',10);
            $table->string('MAIL_FROM_ADDRESS',50);
            $table->string('MAIL_FROM_NAME',50);
            $table->bigInteger('organisation_id'); 
            $table->foreign('organisation_id')->references('id')->on('organisation')->onDelete('cascade');
            $table->unique('organisation_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisation_config_mail');
    }
};
