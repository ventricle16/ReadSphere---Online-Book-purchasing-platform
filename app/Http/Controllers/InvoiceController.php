<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Order; // Assuming you already have an Order model
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Show invoice on browser after successful payment
     */
    public function show($orderId)
    {
        $order = Order::with('items.book')->findOrFail($orderId);

        // Calculate pricing details similar to checkout
        $subtotal = 0;
        foreach ($order->items as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        // Assuming discount, shipping, tax, and final total are stored or calculated
        // For demo, let's assume no discount and free shipping, tax 8%
        $discountAmount = 0;
        $discountCode = null;
        $subtotalAfterDiscount = $subtotal - $discountAmount;
        $shipping = 'Free';
        $tax = $subtotalAfterDiscount * 0.08;
        $finalTotal = $subtotalAfterDiscount + $tax;

        return view('invoice.show', compact(
            'order',
            'subtotal',
            'discountAmount',
            'discountCode',
            'subtotalAfterDiscount',
            'shipping',
            'tax',
            'finalTotal'
        ));
    }

    /**
     * Download invoice as PDF
     */
    public function download($orderId)
    {
        $order = Order::with('items.book')->findOrFail($orderId);

        $pdf = Pdf::loadView('invoice.pdf', compact('order'));
        return $pdf->download('invoice_'.$order->id.'.pdf');
    }
    public function apiShow(Order $order)
    {
        return response()->json([
            'invoice_id'   => $order->id,
            'user'         => $order->user->name ?? 'Unknown',
            'items'        => $order->items, // assuming relation exists
            'amount'       => $order->amount,
            'status'       => $order->status,
            'created_at'   => $order->created_at,
        ]);
    }

    // ✅ API version - download invoice as PDF via API
    public function apiDownload(Order $order)
    {
        $pdf = PDF::loadView('invoice.show', compact('order'));
        return $pdf->download("invoice_{$order->id}.pdf");
    }
    public function apiStore(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Create invoice entry
        $invoice = Invoice::create([
            'order_id'   => $order->id,
            'user_id'    => $order->user_id,
            'amount'     => $order->amount,
            'status'     => 'Paid', // You can set based on payment info
        ]);

        return response()->json([
            'message' => 'Invoice generated successfully',
            'invoice' => $invoice
        ], 201);
    }

}