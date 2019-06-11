<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_tokens', function (Blueprint $table) {
            $table->unsignedBigInteger('driver_id')->unique();
            $table->foreign('driver_id')
            ->references('id')->on('drivers');
            $table->string('token')->unique();
            $table->primary(['driver_id', 'token']);
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
        Schema::dropIfExists('driver_tokens');
    }
}
