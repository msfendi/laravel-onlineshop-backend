<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Midtrans\CreateVAService;

class OrderController extends Controller
{
    // function order
    public function order(Request $request)
    {
        // validasi data
        $this->validate($request, [
            'address_id' => 'required',
            'payment_method' => 'required',
            'payment_va_name' => 'required',
            'shipping_service' => 'required',
            'subtotal' => 'required',
            'shipping_cost' => 'required',
            'total_price' => 'required',
            'items' => 'required'
        ]);

        $subtotal = 0;
        foreach ($request->items as $item) {
            // get product price
            $product = Product::find($item['product_id']);
            $subtotal += $item['quantity'] * $product->price;
        }

        // create order
        $order = Order::create([
            'user_id' => $request->user()->id,
            'address_id' => $request->address_id,
            'subtotal' => $subtotal,
            'shipping_cost' => $request->shipping_cost,
            'total_price' => $subtotal + $request->shipping_cost,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'shipping_service' => $request->shipping_service,
            'shipping_resi' => $request->shipping_resi,
            'transaction_number' => 'TRX' . rand(100000, 999999)
        ]);

        // if payment_va_name is not null, then update the order
        if ($request->payment_va_name) {
            $order->update([
                'payment_va_name' => $request->payment_va_name,
            ]);
        }

        // create order items
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity']
            ]);
        }

        // request midtrans
        if ($request->payment_method == 'bank_transfer') {
            // create VA
            $midtrans = new CreateVAService($order->load('user', 'orderItems'));
            $response = $midtrans->getVa();

            $order->payment_va_number = $response->va_numbers[0]->va_number;
            $order->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Order successfully created',
            'data' => $order
        ], 201);
    }
}
