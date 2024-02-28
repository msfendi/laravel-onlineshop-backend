<?php

namespace App\Services\Midtrans;

use Midtrans\CoreApi;
use Midtrans\Snap;

class CreateVAService extends Midtrans
{
    // retrieve order data from controller
    protected $order;

    public function __construct($order)
    {
        parent::__construct();

        $this->order = $order;
    }

    public function getVa()
    {
        // perulangan order item
        $itemDetails = [];
        foreach ($this->order->orderItems as $item) {
            $itemDetails[] = [
                'id' => $item->product->id,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'name' => $item->product->name,
            ];
        }

        // add shipping cost to item details
        $itemDetails[] = [
            'id' => 'SHIPPING_COST',
            'price' => $this->order->shipping_cost,
            'quantity' => 1,
            'name' => 'Shipping Cost',
        ];

        $params = [
            'payment_type' => 'bank_transfer',
            'transaction_details' => [
                'order_id' => $this->order->transaction_number,
                'gross_amount' => $this->order->total_price,
            ],
            'item_details' => $itemDetails,

            'customer_details' => [
                'first_name' => $this->order->user->name,
                'email' => $this->order->user->email,
            ],
            'bank_transfer' => [
                'bank' => $this->order->payment_va_name,
            ],
        ];

        // create VA request with Core API
        $response = CoreApi::charge($params);

        return $response;
    }
}
