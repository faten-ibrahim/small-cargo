<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->softDeletes();
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('address');
            $table->double('address_latitude')->nullable();
            $table->double('address_longitude')->nullable();
            $table->string('phone');
            $table->string('status')->enum('status', ['active', 'inactive','new','contact'])->default('new');
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
        Schema::dropIfExists('companies');
    }
}
