<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyemployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companyemployee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name');
            $table->bigInteger('user_id')->unsigned()->nullable(true);
            $table->bigInteger('company_id')->unsigned();
            $table->bigInteger('status_id')->unsigned()->nullable(true);
            $table->string('phone_number');
            $table->string('image');
            $table->boolean('system_account');
            $table->boolean('active');

            $table->foreign('company_id')->references('id')->on('company');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companyemployees');
    }
}
