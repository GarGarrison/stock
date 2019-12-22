<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('num');
            $table->string('address');
            $table->string('goodsname');
            $table->string('mark');
            $table->string('producer');
            $table->string('case');
            $table->float('price_retail_usd');
            $table->float('price_retail_rub');
            $table->float('price_minitrade_usd');
            $table->float('price_minitrade_rub');
            $table->float('price_trade_usd');
            $table->float('price_trade_rub');
            $table->integer('packcount');
            $table->float('price_pack_usd');
            $table->float('price_pack_rub');
            $table->integer('onlinecount');
            $table->integer('offlinecount');
            $table->string('cell', 32);
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
        Schema::dropIfExists('goods');
    }
}
