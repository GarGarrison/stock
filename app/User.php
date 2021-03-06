<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    // public $timestamps = false;

    public $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $guarded = ['id',];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'passwd', 'remember_token',
    ];
    protected $fillable = [
        "name",
        "login",
        "passwd",
        "type",
        "money",
        "price_level",
        "discount",
        "storage",
        "num_start",
        "num_end",
    ];
    public function isAdmin() {
        return $this->type == "Администратор";
    }
    public function isStorage() {
        return $this->type == "Склад";
    }
}
