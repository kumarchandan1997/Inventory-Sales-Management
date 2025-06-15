<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\SalesOrder;

class SalesOrderController extends Controller
{
     public function create()
     {
        $products = Product::all();
        return view('sales_orders.create', compact('products'));
     }

     public function store(Request $request)
     {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

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

                $product->decrement('quantity', $p['quantity']);
            }

            $order = SalesOrder::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

            DB::commit();
            return redirect()->route('sales-orders.create')->with('success', 'Order placed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function downloadPdf(SalesOrder $order)
    {
        $order->load('items.product');
        $pdf = Pdf::loadView('sales_orders.pdf', compact('order'));
        return $pdf->download("sales_order_{$order->id}.pdf");
    }

     public function myOrders()
    {
        $orders = SalesOrder::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('sales.my_orders', compact('orders'));
    }


}
