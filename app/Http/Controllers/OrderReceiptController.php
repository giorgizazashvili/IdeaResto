<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderReceiptController extends Controller
{
    public function show(Order $order)
    {
        // Load relationships
        $order->load(['table', 'user', 'items.dish']);

        return view('orders.receipt', [
            'order' => $order,
        ]);
    }
}
