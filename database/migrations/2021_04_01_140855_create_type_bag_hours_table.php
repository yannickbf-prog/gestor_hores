<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeBagHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_bag_hours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique()->length(50);
            $table->double('hour_price',7,2);
            $table->string('description')->nullable()->length(400);
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
        Schema::dropIfExists('type_bag_hours');
    }
}
