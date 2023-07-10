<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockiestTerritoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockiest_territories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stockiest_id');
            $table->bigInteger('territories_id');
            $table->bigInteger('sub_territories');
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
        Schema::dropIfExists('stockiest_territories');
    }
}
