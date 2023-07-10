<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerritoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('territories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('territory_id');
            $table->bigInteger('state_id');
            $table->bigInteger('country_id');
            $table->tinyInteger('is_active')->default(1)->comment = '1 for active 2 deactive';
            $table->tinyInteger('is_delete')->default(0)->comment = '0 for not deleted 2 deleted';
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
        Schema::dropIfExists('territories');
    }
}
