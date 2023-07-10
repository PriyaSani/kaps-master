<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_stores', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->text('store_address');
            $table->text('store_phone_number');
            $table->text('store_email_id');
            $table->text('gst_number');
            $table->tinyInteger('is_active')->default(1)->comment = '1 Active  0 deactive';
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
        Schema::dropIfExists('medical_stores');
    }
}
