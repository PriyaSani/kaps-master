<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_details', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('specialization');
            $table->string('email');
            $table->string('mobile_number');
            $table->date('dob');
            $table->date('anniversary_date');
            $table->text('remarks')->nullable();
            $table->string('clininc_name')->nullable();
            $table->text('clinic_address')->nullable();
            $table->date('clinic_opening_date')->nullable();
            $table->tinyInteger('is_active')->default(1)->comment = '1 active  0 deactive';
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
        Schema::dropIfExists('doctor_details');
    }
}
