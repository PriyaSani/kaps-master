<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalStoreDoctorDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_store_doctor_data', function (Blueprint $table) {
            $table->id();
             $table->bigInteger('doctor_id');
            $table->bigInteger('medical_store_id');
            $table->bigInteger('stockiest_id');
            $table->bigInteger('mr_id');
            $table->date('sales_month')->nullable();
            $table->bigInteger('sales_amount')->nullable();
            $table->date('submitted_on')->nullable();
            $table->tinyInteger('priority')->default(0)->comment = '1 fillable  0 not fillable';
            $table->tinyInteger('is_delete')->default(0)->comment = '1 delete  0 not delete';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_store_doctor_data');
    }
}
