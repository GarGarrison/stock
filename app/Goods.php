<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';

    // protected $guarded = ['id',];

    protected $fillable = [
        "num",
        "address",
        "goodsname",
        "mark",
        "producer",
        "case",
        "price_retail_usd",
        "price_retail_rub",
        "price_minitrade_usd",
        "price_minitrade_rub",
        "price_trade_usd",
        "price_trade_rub",
        "packcount",
        "price_pack_usd",
        "price_pack_rub",
        "onlinecount",
        "offlinecount",
        "cell",
    ];
}
