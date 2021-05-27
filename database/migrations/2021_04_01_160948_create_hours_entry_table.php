<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoursEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hours_entry', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_project_id');
            $table->foreign('user_project_id')->references('id')->on('users_projects');
            $table->unsignedBigInteger('bag_hours_id');
            $table->nullable()->foreign('bag_hours_id')->references('id')->on('bag_hours');
            $table->integer('hours');
            $table->boolean('validate');
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
        Schema::dropIfExists('hours_entry');
    }
}
