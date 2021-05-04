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
            $table->string('name')->length(15);
            $table->string('img_logo')->nullable()->length(15);
            $table->string('work_sector')->length(70);
            $table->string('description')->nullable()->length(400);
            $table->string('email')->nullable()->length(50);
            $table->bigInteger('phone')->nullable();
            $table->string('website')->nullable()->length(50);
            $table->string('default_lang')->nullable()->length(2);
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
