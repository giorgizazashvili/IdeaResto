<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index()
    {
        $orders = Order::with(['table', 'items.dish', 'user'])
            ->whereIn('status', [
                Order::STATUS_PENDING,
                Order::STATUS_CONFIRMED,
                Order::STATUS_PREPARING,
                Order::STATUS_READY,
            ])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('kitchen.display', compact('orders'));
    }

    public function updateStatus(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->status = $request->status;
        $order->save();

        // მაგიდის სტატუსის განახლება
        if ($request->status === Order::STATUS_SERVED) {
            $order->table->update(['status' => \App\Models\Table::STATUS_AVAILABLE]);
        } elseif (in_array($request->status, [Order::STATUS_CONFIRMED, Order::STATUS_PREPARING])) {
            $order->table->update(['status' => \App\Models\Table::STATUS_OCCUPIED]);
        }

        return response()->json(['success' => true]);
    }
}
