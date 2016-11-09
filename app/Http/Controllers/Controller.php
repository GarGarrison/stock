<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Order;
use App\User;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $status = array(
        0 => array(
            "status" => "img/wait.png",
            "maydelete" => "<img class = 'pointer delete-position' src='img/delete.png'>"),
        1 => array(
            "status" => "img/canceled.png",
            "maydelete" => "<img class = 'pointer change-canceled' src='img/order.png'>"),
        2 => array(
            "status" => "img/building.png",
            "maydelete" => ""),
        3 => array(
            "status" => "img/built.png",
            "maydelete" => ""),
        4 => array(
            "status" => "img/built.png",
            "maydelete" => ""),
        5 => array(
            "status" => "img/unavail.png",
            "maydelete" => ""),
        7 => array(
            "status" => "img/not_ordered.png",
            "maydelete" => "<img class = 'pointer delete-position' src='img/delete.png'>"),
        8 => array(
            "status" => "img/built.png",
            "maydelete" => "")
    );

    public $delay_time = 15 * 60;

    public function getTime(){
        return Carbon::now()->timestamp;
    }

    public function getTimeDelta(){
        return Carbon::now()->addSeconds($this->delay_time)->timestamp;
    }

    public function updateOrder($join) { 
        $order = Order::find($join->orderid);
        $order->update([
            "status" => 2,
            "storage_time" => $this->getTime()
        ]);
    }

    protected function getOrders() {
        $user = Auth::user();
        DB::statement('SET SQL_BIG_SELECTS=1');
        $orders = DB::table('orders')
            ->where('user', $user->id)
            ->where('status','<>', '6')
            ->join('goods', 'goods.num', '=', 'orders.goods')
            ->select('orders.id as orderid', 'orders.*', 'goods.*')
            ->orderBy('orderid', 'desc')->get();
        return $orders;
    }

    public function getStorageOrderTime($user) {
        $order = DB::table('orders')
            ->where(function($query){
                $query->where('status', '2');
                $query->where('storage_time', '<', $this->getTimeDelta());
                $query->orWhere('status', 0);
            })
            ->leftJoin('goods', 'orders.goods', '=', 'goods.num')
            ->select('orders.id as orderid', 'orders.*', 'goods.*')
            ->where($user->storage, '<>', 0)
            ->orderBy('datetime', 'desc')->first();
        $this->updateOrder($order);
        return $order;
    }

    public function getStorageOrderNoTime($user) {
        $order = DB::table('orders')
            ->where('status', 0)
            ->leftJoin('goods', 'orders.goods', '=', 'goods.num')
            ->select('orders.id as orderid', 'orders.*', 'goods.*')
            ->where($user->storage, '<>', 0)
            ->orderBy('datetime', 'desc')->first();
        $this->updateOrder($order);
        return $order;
    }

    public function getStorageOrder($user, $isIndex) {
        $client = "";
        $order = "";
        if ($isIndex) $order = $this->getStorageOrderNoTime($user);
        else $order = $this->getStorageOrderTime($user);
        if ($order) $client = User::find($order->user);
        return array($order, $client);
    }
}
