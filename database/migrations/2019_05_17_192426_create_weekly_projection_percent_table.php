<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeklyProjectionPercentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_projection_percent', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('store_week_id')->unsigned();;
            $table->decimal('target_cog',3,1);
            $table->timestamps();

            $table->foreign('store_week_id')->references('id')->on('store_week');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weekly_projection_percent');
    }
}
