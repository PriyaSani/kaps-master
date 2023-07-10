<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockiestStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockiest_statements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('data_id');
            $table->string('statement');
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
        Schema::dropIfExists('stockiest_statements');
    }
}
