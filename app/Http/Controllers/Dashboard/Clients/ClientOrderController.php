<?php

namespace App\Http\Controllers\Dashboard\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Client;
use App\Order;
use App\Product;

class ClientOrderController extends Controller
{
    
    
    public function create(Client $client)
    {
        return view('dashboard.clients.orders.create', ['client'=>$client]);
    }

    
    public function store(Request $request, Client $client)
    {
        $rules = [
            'products_id' => 'required|array',
            'quantity' => 'required|array'
        ];
        $this->validate($request, $rules);
        // Save Request Data On Products Table ['total_price','client_id']
        $total_price = 0;
        for($i =0; $i < count($request->products_id); $i++) {
            $total_price +=  $request->quantity[$i] * Product::findOrFail($request->products_id[$i])->sale_price;
        } // We calculate the TOTAL Price directly from our DB NOT from Front 
        $data = $request->except(['products_id','quantity']);
        $data['total_price'] = $total_price;
        $data['client_id'] = $client->id;
        $order = Order::create($data);
        // Save Data on order_product table ['order_id','product_id','quantity'] using attach method
        foreach($request->products_id as $index=>$product_id) {
            $order->products()->attach($product_id, ['quantity' => $request->quantity[$index]]); //Foreach product_id set quantity 
        }
        
        return redirect()->route('dashboard.orders.index')->with('msg_ok',trans('messages.add_new_order'));
    }

   
    public function edit(Client $client, Order $order)
    {
        return view('dashboard.clients.orders.edit', ['client'=>$client, 'order'=>$order]);
    }

   
    public function update(Request $request, Client $client, Order $order)
    {
        $rules = [
            'products_id' => 'required|array',
            'quantity' => 'required|array',
        ];
        $this->validate($request, $rules);
        // Remove Data from order_product table before Update
        foreach($order->products as $index=>$product) {
            $order->products()->detach($product, ['quantity' => $product->quantity[$index]]);
        }
        // Save Request Data On Products Table ['total_price','client_id']
        $total_price = 0;
        for($i =0; $i < count($request->products_id); $i++) {
            $total_price +=  $request->quantity[$i] * Product::findOrFail($request->products_id[$i])->sale_price;
        } // We calculate the TOTAL Price directly from our DB NOT from Front 
        $data = $request->except(['products_id','quantity']);
        $data['total_price'] = $total_price;
        $data['client_id'] = $client->id;
        $order->update($data);
        // Save Data on order_product table ['order_id','product_id','quantity'] using attach method
        foreach($request->products_id as $index=>$product_id) {
            $order->products()->attach($product_id, ['quantity' => $request->quantity[$index]]); //Foreach product_id set quantity 
        }
        
        return redirect()->route('dashboard.orders.index')->with('msg_ok',trans('messages.update_order'));
    }

}
