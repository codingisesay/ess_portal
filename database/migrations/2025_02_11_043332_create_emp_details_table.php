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
        Schema::create('emp_details', function (Blueprint $table) {
            $table->id();
            // $table->string('employee_type',10); //fk
            $table->bigInteger('employee_type'); 
            $table->foreign('employee_type')->references('id')->on('employee_type')->onDelete('cascade');
            $table->string('employee_no',50);
            $table->string('employee_name',50);
            $table->date('Joining_date');
            // $table->date('reporting_manager'); //FK
            $table->bigInteger('reporting_manager'); 
            $table->foreign('reporting_manager')->references('id')->on('user')->onDelete('cascade');
            $table->string('total_experience',50);
            // $table->string('designation',50); //fk
            $table->bigInteger('designation'); 
            $table->foreign('designation')->references('id')->on('organisation_designations')->onDelete('cascade');
            // $table->string('department',50); //fk
            $table->bigInteger('department'); 
            $table->foreign('department')->references('id')->on('organisation_departments')->onDelete('cascade');
            $table->enum('gender', ['Male', 'Female', 'other']);
            $table->date('date_of_birth');
            $table->enum('blood_group', ['A+', 'A-', 'B+','B-','O+','O-','AB+','AB-']);
            $table->string('nationality',50);
            $table->enum('religion',['Hinduism','Islam','Christianity','Sikhism','Buddhism','Jainism','Zoroastrianism','Judaism','Baha i Faith','Other']);
            $table->enum('marital_status',['Single','Married','Divorced']);
            $table->date('anniversary_date');
            $table->string('universal_account_number',50);
            $table->string('provident_fund',100);
            $table->string('esic_no',100);
            // $table->string('user_id');  //fk
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
        Schema::dropIfExists('emp_details');
    }
};
