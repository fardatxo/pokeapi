<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_name'           => 'required|string|max:255',
            'client_email'          => 'required|email',
            'client_phone'          => 'required|string|max:20',
            'address'               => 'required|string|max:255',
            'city'                  => 'required|string|max:100',
            'postal_code'           => 'required|string|max:10',
            'payment_last4'         => 'required|string|size:4',
            'items'                 => 'required|array|min:1',
            'items.*.product_id'    => 'required|integer',
            'items.*.product_name'  => 'required|string',
            'items.*.product_brand' => 'required|string',
            'items.*.price'         => 'required|numeric',
            'items.*.qty'           => 'required|integer|min:1',
        ]);

        $total = collect($data['items'])->sum(fn ($i) => $i['price'] * $i['qty']);

        $order = Order::create([
            'user_id'       => $request->user('sanctum')?->id,
            'client_name'   => $data['client_name'],
            'client_email'  => $data['client_email'],
            'client_phone'  => $data['client_phone'],
            'address'       => $data['address'],
            'city'          => $data['city'],
            'postal_code'   => $data['postal_code'],
            'total'         => $total,
            'payment_last4' => $data['payment_last4'],
            'status'        => 'paid',
        ]);

        foreach ($data['items'] as $item) {
            $order->items()->create([
                'product_id'    => $item['product_id'],
                'product_name'  => $item['product_name'],
                'product_brand' => $item['product_brand'],
                'price'         => $item['price'],
                'qty'           => $item['qty'],
            ]);
        }

        return response()->json($order->load('items'), 201);
    }
}
