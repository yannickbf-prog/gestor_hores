<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nickname')->unique()->length(20);
            $table->string('name')->length(50);
            $table->string('surname')->length(100);
            $table->string('email')->unique()->length(50);
            $table->bigInteger('phone')->unique()->nullable();
            $table->text('description')->nullable()->length(400);
            $table->enum('role', ['user','admin'])->default('user')->length(5);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
