<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){
        $user = User::find(auth()->id());
        $orders = $user->carts()->orderBy("id","desc")->get();
        return Inertia::render('Dashboard',['orders'=>$orders]);
    }
}
