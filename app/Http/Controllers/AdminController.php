<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class AdminController extends Controller
{
    public function finduser(Request $request) {
        $user = User::find($request['id']);
        return view("util.user_form", ["current" => $user]);
    }

    public function adduser(Request $request) {
        User::create([
            "name" => $request['name'],
            "login" => $request['login'],
            "passwd" => sha1($request['passwd']),
            "type" => $request['type'],
            "money" => $request['money'],
            "price_level" => $request['price_level'],
            "discount" => $request['discount'],
            "storage" => $request['storage']
        ]);
        return redirect()->back();
    }

    public function saveuser(Request $request) {
        $user = User::find($request['id']);
        $pass = $request['passwd'];
        $user->update([
            "name" => $request['name'],
            "login" => $request['login'],
            "type" => $request['type'],
            "money" => $request['money'],
            "price_level" => $request['price_level'],
            "discount" => $request['discount'],
            "storage" => $request['storage']
        ]);
        if ($pass) $user->update(["passwd" => sha1($pass)]);
        return redirect()->back();
    }

    public function deleteuser(Request $request) {
        User::destroy($request['uid']);
    }
}
