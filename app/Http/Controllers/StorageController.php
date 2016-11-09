<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Order;
use App\User;
use DB;
class StorageController extends Controller
{   
    public function reloadstorage() {
        $user = Auth::user();
        list($order, $client) = $this->getStorageOrder($user);
        $this->updateOrder($order);
        $data = ["order" => $order, "client"=>$client, "user" => $user];
        return view('util.storage_table', $data);
    }

    public function checkneworders(Request $request) {
        list($order, $client) = $this->getStorageOrder($user);
        if ($order) return "1";
        else return "0";
    }

    public function changedonecount(Request $request) {
        $order = Order::find($request['oid']);
        $order->update(["countdone" => $request['count']]);
    }

    public function changetakeplace(Request $request) {
        $order = Order::find($request['oid']);
        $order->update(["takeplace" => $request['place']]);
    }

    public function changestatus(Request $request) {
        $user = Auth::user();
        $order = Order::find($request['oid']);
        $clientId = $order->user;
        $nextClient = "";
        $order->update([
            "takeplace" => $request["takeplace"],
            "status" => $request["status"],
            "countdone" => $request["countdone"],
            "employee" => $user->id
        ]);
        // следующий заказ от того же клиента
        $nextOrder = DB::table('orders')
            ->where('user', $clientId)
            ->where(function($query){
                $query->where('status', '2');
                $query->where('storage_time', '<', $this->getTimeDelta());
                $query->orWhere('status', 0);
            })
            ->leftJoin('goods', 'orders.goods', '=', 'goods.num')
            ->select('orders.id as orderid', 'orders.*', 'goods.*')
            ->where($user->storage, '<>', 0)
            ->orderBy('datetime', 'desc')->first();

        // если таких нет, ищем любой другой
        if (!$nextOrder) {
            $nextOrder = DB::table('orders')
                ->where(function($query){
                    $query->where('status', '2');
                    $query->where('storage_time', '<', $this->getTimeDelta());
                    $query->orWhere('status', 0);
                })
                ->leftJoin('goods', 'orders.goods', '=', 'goods.num')
                ->select('orders.id as orderid', 'orders.*', 'goods.*')
                ->where($user->storage, '<>', 0)
                ->orderBy('datetime', 'desc')->first();
        }
        if ($nextOrder) {
            $nextClient = User::find($nextOrder->user);
            $takeplace = $nextOrder->takeplace;
            if ( $takeplace == "" && $clientId == $nextClient->id) $takeplace = $request["takeplace"];
            $this->updateOrder($nextOrder, $takeplace);
        }
        $data = ["order" => $nextOrder, "client"=>$nextClient, "user" => $user];
        return view('util.storage_table', $data);
    }
}
