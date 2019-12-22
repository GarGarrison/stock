<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // public $timestamps = false;
    public $table = 'order';
    // protected $guarded = ['id',];
    protected $fillable = [
        "user",
        "storage_user",
        "storage_time",
        "goods",
        "countorder",
        "countdone",
        "price",
        "money",
        "status",
        "employee",
        "takeplace",
        "datetime",
        "billid",
    ];
}
