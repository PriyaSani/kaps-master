<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockiestUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockiest_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stockiest_id');
            $table->bigInteger('associated_user_id');
            $table->bigInteger('engagement_type');
            $table->bigInteger('role');
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
        Schema::dropIfExists('stockiest_users');
    }
}
