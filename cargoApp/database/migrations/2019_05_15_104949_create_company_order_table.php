<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_order', function (Blueprint $table) {

            $table->unsignedBigInteger('sender_id');
            $table->foreign('sender_id')
            ->references('id')->on('users');

            $table->unsignedBigInteger('receiver_id');
            $table->foreign('receiver_id')
            ->references('id')->on('users');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
            ->references('id')->on('orders');

            $table->primary(['sender_id', 'receiver_id','order_id']);

            $table->string('contact_name',150);
            $table->boolean('saved')->default(false);
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
        Schema::dropIfExists('company_order');
    }
}
