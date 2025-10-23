<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderReource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display orders belonging to a particular Auth user/vendor who listed it.
     */
    public function index()
    {
        return  $this->authorize('viewAny', Order::class);   
    }

    /**
     * customer creates an order.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'total' => 'required|numeric',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        if($validator->fails()){
            return response()->json(['message'=>'invalid order data', 'error'=>$validator->errors()],422);
        }

        $order = Order::create([
            'customer_name'=>$request->customer_name,
            'customer_phone'=>$request->customer_phone,
            'customer_email'=>$request->customer_email,
            'address'=>$request->address,
            'total'=>$request->total
        ]);

        $order->items()->createMany($request->items);

        return response()->json([
            'message'=>'Order saved successfully',
            // 'data' => $order->load('items'),
            'data' => new OrderReource($order)

            ],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
