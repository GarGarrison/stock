<?php
    # order statuses
    # 0 - ожидание
    # 1 - отменено
    # 2 - в наборе
    # 3 - набрано (не полностью)
    # 4 - набрано (полностью)
    # 5 - нет на складе
    # 6 - отгружено
    # 7 - набирать
    
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Goods;
use App\Order;
use App\User;
use DB;
use Carbon\Carbon;
class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //parent::__construct();
    }

    public function index(Request $request) {
        $data = array();
        $user = Auth::user();
        if ($user->type == "Клиент") $data = ["order_list" => $this->getOrders(), "status"=>$this->status];
        elseif ($user->type == "Администратор") $data = ["user_list" => User::all(), "current" => ""];
        elseif ($user->type == "Склад") {
            list($order, $client) = $this->getStorageOrder($user, true);
            $data = ["order" => $order, "client"=>$client, "user" => $user];
        }
        return view($user->type, $data);
    }

    public function shipped(Request $request) {
        $req = array();
        $order_list = DB::table('order')
            ->where('user', Auth::id())
            ->where('status', '6')
            ->where('billid', '<>', 0)
            ->join('goods', 'goods.num', '=', 'order.goods')
            ->select('order.id as orderid', 'order.*', 'goods.*')
            ->orderBy('datetime', 'desc')->get()->toArray();
        foreach ($order_list as $order) {
            $bill = $order->billid;
            if (isset($req[$bill])) $req[$bill][] = $order;
            else $req[$bill] = array($order);
        }
        //return var_dump($req);
        return view('shipped', ["bill_list" => $req]);
    }

    public function reloadOrder(Request $request) {
        $orders = $this->getOrders();
        return view('util.orders_table', ["order_list" => $orders, "status"=>$this->status]);
    }

    public function search(Request $request) {
        $search = $request['search'];
        $req_search = '%'.$search.'%';
        $goods_list = Goods::where('goodsname', 'like', $req_search)->orWhere('mark', 'like', $req_search)->get();
        return view('util.search', ["goods_list" => $goods_list]);
    }

    public function addorder(Request $request) {
        $good = Goods::where('num', $request['id'])->first();
        $user = Auth::user();
        $price = 0;
        if ($user->price_level=='Розничные') $price = $user->money=='$' ? $good->price_retail_usd: $good->price_retail_rub;
        if ($user->price_level=='Мелкооптовые') $price = $user->money=='$' ? $good->price_minitrade_usd: $good->price_minitrade_rub;
        if ($user->price_level=='Оптовые') $price = $user->money=='$' ? $good->price_trade_usd: $good->price_trade_rub;
        Order::create([
            'user' => $user->id,
            'goods' => $request['id'],
            'datetime' => Carbon::now(),
            'countorder' => $request['count'],
            'countdone' => 0,
            'money' => $user->money,
            'price' => $price,
            'status' => $request['status'],
            'employee' => 0
        ]);
        $orders = $this->getOrders();
        return view('util.orders_table', ["order_list" => $orders, "status"=>$this->status]);
    }

    public function changeorder(Request $request) {
        $order = Order::find($request['id']);
        if (isset($request['status'])) {
            $order->update([
                'status' => $request['status']
            ]);
        }
        if (isset($request['count'])) {
            $order->update([
                'countorder' => $request['count']
            ]);
        }
        $order->save();

    }

    public function ordernotordered() {
        Order::where('user', Auth::id())
            ->where('status', 7)
            ->update(['status' => 0]);
    }

}
