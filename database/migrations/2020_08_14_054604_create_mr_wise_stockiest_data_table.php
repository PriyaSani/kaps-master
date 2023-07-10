<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrWiseStockiestDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mr_wise_stockiest_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stockiest_id');
            $table->bigInteger('mr_id');
            $table->date('sales_month')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->date('submitted_on')->nullable();
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
        Schema::dropIfExists('mr_wise_stockiest_data');
    }
}
