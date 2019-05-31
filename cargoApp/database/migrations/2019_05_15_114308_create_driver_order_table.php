<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_order', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
            ->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')
            ->references('id')->on('drivers')->onDelete('cascade');
            $table->primary(['driver_id','order_id']);
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
        Schema::dropIfExists('driver_order');
    }
}
