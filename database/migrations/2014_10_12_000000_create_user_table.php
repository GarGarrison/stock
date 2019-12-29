<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('login', 32);
            $table->string('passwd', 40);
            $table->string('type', 32);
            $table->string('money', 8);
            $table->string('price_level', 32);
            $table->float('discount');
            $table->string('storage', 12);
            $table->integer('num_start')->default(1);
            $table->integer('num_end')->default(100000);
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
        Schema::dropIfExists('user');
    }
}
