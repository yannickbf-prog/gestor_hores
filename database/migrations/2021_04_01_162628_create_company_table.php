<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');
            $table->string('img_logo')->nullable();
            $table->string('work_sector');
            $table->string('description')->nullable();
            $table->string('email')->nullable();
            $table->integer('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('default_lang');
            $table->string('date_format');
            $table->string('currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');
    }
}
