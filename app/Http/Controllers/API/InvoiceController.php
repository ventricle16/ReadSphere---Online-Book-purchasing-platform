<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    // Generate invoice for an order
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Generate unique invoice number
        $invoiceNumber = 'INV-' . strtoupper(Str::random(8));

        $invoice = Invoice::create([
            'order_id' => $order->id,
            'user_id'  => $order->user_id,
            'invoice_number' => $invoiceNumber,
            'amount'   => $order->amount,
            'status'   => 'generated',
        ]);

        return response()->json([
            'message' => 'Invoice generated successfully',
            'invoice' => $invoice
        ], 201);
    }

    // Get all invoices
    public function index()
    {
        return response()->json(Invoice::all());
    }

    // Get invoice by ID
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return response()->json($invoice);
    }

    // Delete invoice
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted successfully']);
    }
}
