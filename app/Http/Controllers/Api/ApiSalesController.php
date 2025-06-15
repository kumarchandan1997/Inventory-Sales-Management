<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\SalesOrder;


class ApiSalesController extends Controller
{
    public function products()
    {
        return Product::all();
    }

   public function store(Request $request)
{
    // Optionally use Validator if you want full control over response
    $validator = Validator::make($request->all(), [
        'products' => 'required|array|min:1',
        'products.*.id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    DB::beginTransaction();

    try {
        $total = 0;
        $items = [];

        foreach ($request->products as $p) {
            $product = Product::findOrFail($p['id']);

            if ($product->quantity < $p['quantity']) {
                throw new \Exception("Insufficient stock for {$product->name}");
            }

            $subtotal = $product->price * $p['quantity'];
            $total += $subtotal;

            $items[] = [
                'product_id' => $product->id,
                'quantity' => $p['quantity'],
                'price' => $product->price
            ];

            // Reduce stock
            $product->decrement('quantity', $p['quantity']);
        }

        // Create sales order
        $order = SalesOrder::create([
            'user_id' => auth()->id(),  // assumes Sanctum
            'total_amount' => $total,
        ]);

        // Add order items
        foreach ($items as $item) {
            $order->items()->create($item);
        }

        DB::commit();

        return response()->json([
            'message' => 'Order created successfully.',
            'order' => [
                'id' => $order->id,
                'total_amount' => $order->total_amount,
                'products' => $order->items()->with('product:id,name,price')->get()
            ]
        ], 201);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'Order creation failed.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function show($id)
    {
        $order = SalesOrder::with('items.product')->findOrFail($id);
        return response()->json($order);
    }

}
