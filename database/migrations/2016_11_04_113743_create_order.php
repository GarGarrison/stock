<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user');
            $table->integer('storage_user');
            $table->integer('storage_time');
            $table->integer('goods');
            $table->integer('countorder');
            $table->integer('countdone');
            $table->float('price');
            $table->string('money', 16);
            $table->char('status');
            $table->integer('employee');
            $table->string('takeplace', 32);
            $table->datetime('datetime');
            $table->integer('billid');
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
        Schema::dropIfExists('order');
    }
}
