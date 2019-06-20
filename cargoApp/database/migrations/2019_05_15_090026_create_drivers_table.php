<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->softDeletes();
            $table->bigIncrements('id');
            $table->string('name',100);
            $table->string('phone',30);
            $table->string('car_type',100);
            $table->string('car_number',100);
            $table->integer('car_no_of_trips')->default(0);
            $table->integer('rating')->default(0);
            $table->string('status_driver')->enum('status', ['inactive', 'active','new'])->default('new');
            $table->string('availability')->enum('availability', ['available', 'offline','busy'])->default('available');
            // $table->unsignedInteger('user_id')->nullable();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('drivers');
    }
}
