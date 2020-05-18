<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Order;
use App\Client;
class OrderController extends Controller
{
  
    public function index(Request $request)
    {
        $orders= Order::whereHas('client', function($query)use($request) {
            $query->where('name', 'like','%'.$request->search.'%')
                ->orWhere('total_price','like','%'.$request->search.'%');
        //             // ->orWhere('created_at','like','%'.$request->search.'%');
        })->get();

        return view('dashboard.orders.index')->with('orders',$orders);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('dashboard.orders.index')->with('msg_danger',trans('messages.delete_order'));
    }

    public function show_order_products(Order $order) {
        $products = $order->products()->get();
        return view('dashboard.orders._show_products', ['products'=>$products,'order'=>$order]);
    }
}
