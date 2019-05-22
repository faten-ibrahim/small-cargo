<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('length');
            $table->float('width');
            $table->float('height');
            $table->string('photo');
            $table->string('pickup_location');
            $table->string('drop_off_location');
            $table->string('value')->enum('value', ['cheap', 'medium','expensive']);
            $table->float('Weight');
            $table->string('unit')->enum('unit', ['kg', 'ton']);
            $table->integer('quantity');
            $table->dateTime('time_to_deliver');
            // $table->unsignedbigInteger('order_id')->nullable();
            // $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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
        Schema::dropIfExists('packages');
    }
}
