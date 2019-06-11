<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_tokens', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->unique();
            $table->foreign('company_id')
            ->references('id')->on('companies');
            $table->string('token')->unique();
            $table->primary(['company_id', 'token']);
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
        Schema::dropIfExists('company_tokens');
    }
}
