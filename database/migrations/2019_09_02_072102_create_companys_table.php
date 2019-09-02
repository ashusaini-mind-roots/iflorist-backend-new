<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('canceled_acount');
            $table->boolean('activated_acount');
            $table->string('cc',4);
            $table->date('cc_expired_date');
            $table->text('ba_street');
            $table->text('ba_street2');
            $table->string('ba_city');
            $table->string('ba_state');
            $table->string('ba_zip_code',5);
            $table->string('card_holder_name',150);
            $table->timestamps();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companys');
    }
}
