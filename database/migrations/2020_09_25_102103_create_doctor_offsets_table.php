<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorOffsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_offsets', function (Blueprint $table) {
            $table->id();
            $table->string('last_month_sales');
            $table->date('last_month_date');
            $table->string('previous_second_month_sales');
            $table->date('previous_second_month_date');
            $table->string('previous_third_month_sales');
            $table->date('previous_third_month_date');
            $table->string('target_previous_month');
            $table->date('target_previous_month_date');
            $table->string('carry_forward');
            $table->date('carry_forward_date');
            $table->string('eligible_amount');
            $table->date('eligible_amount_date');
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
        Schema::dropIfExists('doctor_offsets');
    }
}
