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

    public function getLastTakeplace($order){
        $takeplace = $order->takeplace;
        if ($takeplace == "") {
            $last = Order::where('user', $order->user)
                ->where('status', '<>', 6)
                ->where('takeplace', '<>', "")
                ->orderBy('datetime', 'desc')->first();
            if ($last) {
                $takeplace = $last->takeplace;
                
            }
        }
        return $takeplace;
    }

    public function updateOrder($join, $takeplace=false) {
        if ($join) {
            if (!$takeplace) $takeplace = $this->getLastTakeplace($join);
            $order = Order::find($join->orderid);
            $order->update([
                "status" => 2,
                "storage_time" => $this->getTime(),
                "takeplace" => $takeplace
            ]);
            $join->takeplace = $takeplace;
        }
    }

    protected function getOrders() {
        $user = Auth::user();
        DB::statement('SET SQL_BIG_SELECTS=1');
        $orders = DB::table('order')
            ->where('user', $user->id)
            ->where('status','<>', '6')
            ->join('goods', 'goods.num', '=', 'order.goods')
            ->select('order.id as orderid', 'order.*', 'goods.*')
            ->orderBy('orderid', 'desc')->get();
        return $orders;
    }

    public function getStorageOrderTime($user) {
        $order = DB::table('order')
            ->where(function($query){
                $query->where('status', '2');
                $query->where('storage_time', '<', $this->getTimeDelta());
                $query->orWhere('status', 0);
            })
            ->leftJoin('goods', 'order.goods', '=', 'goods.num')
            ->select('order.id as orderid', 'order.*', 'goods.*')
            ->where($user->storage, '<>', 0)
            ->orderBy('datetime', 'desc')->first();
        $this->updateOrder($order);
        return $order;
    }

    public function getStorageOrderNoTime($user) {
        $order = DB::table('order')
            ->where('status', 0)
            ->leftJoin('goods', 'order.goods', '=', 'goods.num')
            ->select('order.id as orderid', 'order.*', 'goods.*')
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
