<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderReource;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
            'total' => 'required|decimal',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'invalid order data',
                'error'=>$validator->errors()
            ],422);
        }

        $order = Order::create([
            'Ref' => 'ORD' . Strtoupper(Str::random(10)),
            'customer_name'=>$request->customer_name,
            'customer_phone'=>$request->customer_phone,
            'customer_email'=>$request->customer_email,
            'address'=>$request->address,
            'total'=>$request->total,
        ]);

        // send order notification email to customer
        Mail::to($order->customer_email)->queue(new OrderConfirmation($order, 'customer'));

        // Send order Notification email to vendor
        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)
                ->queue(new OrderConfirmation($order, 'vendor'));
        }

        // save order
        $order->items()->createMany($request->items);

        return response()->json([
            'message'=>'Order saved successfully',
            'data' => $order->load('items'),
            // 'data' => new OrderReource($order)

            ],201);

    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $user = Auth::user();

        $order->load('items.product');

        $vendorItems = $order->items->filter(function($item) use ($user) {
            $this->authorize('view', $item); 
            return true;
        });
    
        if ($vendorItems->isEmpty()) {
            return response()->json([
                'message' => 'You have no items in this order.'
            ], 403);
        }
    
        $vendorOrder = $order->replicate();
        $vendorOrder->setRelation('items', $vendorItems);
    
        return response()->json([
            'message' => 'Order retrieved successfully',
            'data' => new OrderReource($vendorOrder)
        ]);
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
