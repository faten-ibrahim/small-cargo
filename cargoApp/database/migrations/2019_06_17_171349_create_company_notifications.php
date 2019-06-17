<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sender_id');
            $table->foreign('sender_id')
            ->references('id')->on('companies');

            $table->unsignedBigInteger('receiver_id');
            $table->foreign('receiver_id')
            ->references('id')->on('companies');

            $table->string('title')->default('Cargo order');
            $table->string('body')->default('Your order is pending , now');
            
            $table->string('shipment_type')->enum('shipment_type', ['glass','poisonous', 'flammable']);
            $table->dateTime('pickup_date')->nullable();
            $table->integer('car_number');
            $table->string('truck_type',100);
            $table->float('length');
            $table->float('width');
            $table->float('height');
            $table->string('pickup_location');
            $table->double('pickup_latitude')->nullable();
            $table->double('pickup_longitude')->nullable();
            $table->string('drop_off_location');
            $table->double('drop_off_latitude')->nullable();
            $table->double('drop_off_longitude')->nullable();
            $table->string('value')->enum('value', ['cheap', 'medium','expensive']);
            $table->float('Weight');
            $table->integer('quantity');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')
            ->references('id')->on('orders');

            $table->string('status', 2000)->nullable();
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
        Schema::dropIfExists('company_notifications');
    }
}
