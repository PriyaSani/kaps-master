<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociatedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associated_users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->tinyInteger('engagement_type')->default(0)->comment = '0 Primary  1 Secondary';
            $table->tinyInteger('role')->default(0)->comment = '0 owner  1 employee';
            $table->tinyInteger('medical_associate')->default(0)->comment = '1 active  0 deactive';
            $table->tinyInteger('stockiest_associate')->default(0)->comment = '1 active  0 deactive';
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
        Schema::dropIfExists('associated_users');
    }
}
