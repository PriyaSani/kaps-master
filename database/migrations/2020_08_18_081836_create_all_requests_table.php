<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('doctor_id');
            $table->date('request_date');
            $table->date('request_amount');
            $table->bigInteger('sub_territory');
            $table->bigInteger('submitted_by')->nullable();
            $table->tinyInteger('status')->default(0)->comment = '0 Pending,1 Reject,2 Approve';
            $table->tinyInteger('is_payment_genrated')->default(0)->comment = '1 Done  0 Pending';
            $table->date('payment_on');
            $table->tinyInteger('received_by_me')->default(0)->comment = '1 Received  0 Pending';
            $table->date('received_on');
            $table->tinyInteger('is_paid')->default(0)->comment = '1 Paid  0 Pending'; 
            $table->date('paid_on');
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
        Schema::dropIfExists('all_requests');
    }
}
