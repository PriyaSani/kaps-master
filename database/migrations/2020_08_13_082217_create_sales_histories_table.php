<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mr_id');
            $table->string('sales_month');
            $table->date('submitted_on')->nullable();
            $table->bigInteger('confirm_by_id')->nullable();
            $table->tinyInteger('confirm_status')->default(0)->comment = '1 confirm  0 pending';
            $table->tinyInteger('is_submited')->default(0)->comment = '1 submited  0 pending';
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
        Schema::dropIfExists('sales_histories');
    }
}
