<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DateTime;
use App\Http\Requests;
use App\User;
use App\Goods;
use App\Order;
use DB;

class BackofficeController extends Controller
{
    private function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && ($d->format($format) === $date);
    }
    public function backoffice(Request $request) {
        $req = $request->all();
        $secret = $req["secret"];
        if ($secret != "ceiFa2aequaezairaiPhiewae4ahgeem7ra9eegha5Ee5yah6ohchah9yaeth7ji") die("ALARM!");
        try {
            if ($req['action']==='getmaxorder') {
                echo DB::table('order')->max('id');
            }
            elseif ($req['action']==='getorder') {
                $order = Order::find($req['id']);
                echo json_encode($order);
            }
            elseif ($req['action']=='updategoods') {
                $user = Goods::where('num', $req['num'])->first();
                $user->update($req);
                echo 'ok';
            }
            elseif ($req['action']=='insertgoods') {
                $e = Goods::create($req);
                echo $e->id;
            }
            elseif ($req['action']=='deletegoods') {
                Goods::where('id', $req['id'])->delete();
                echo 'ok';
            }
            elseif ($req['action']=='updateorder') {
                $order = Order::find($req['id']);
                $order->update($req);
                echo 'ok';
            }
            elseif ($req['action']=='updateuser') {
                $user = User::find($req['id']);
                $user->update($req);
                echo 'ok';
            }
            elseif ($req['action']=='get_orders_updated_after') {
                if (! $this->validateDate( $req["after"] )) die("either no date param specified or bad date 'after'");
                $orders = Order::select('id')->where('updated_at', '>', $req["after"])->get();
                echo json_encode($orders);
            }
            else {
                echo "Unknown request!";
            }
        } 
        catch (Exception $e) {
            echo "Database error: \r\n" . $e->getMessage();
            exit;
        }

    }
}
