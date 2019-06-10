<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shipment_type')->enum('shipment_type', ['glass','poisonous', 'flammable']);
            $table->dateTime('pickup_date');
            $table->float('estimated_cost');
            $table->float('final_cost');
            $table->string('status')->enum('status', ['pending', 'accepted','ongoing','delivered'])->default('pending');
            $table->string('car_number',100);
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
        Schema::dropIfExists('orders');
    }
}
