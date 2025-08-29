<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\BkashService;
use Illuminate\Http\Request;

class BkashController extends Controller
{
    protected $bkash;

    public function __construct(BkashService $bkash)
    {
        $this->bkash = $bkash;
    }

    // Start Payment
    public function pay($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        $tokenResponse = $this->bkash->getToken();
        $token = $tokenResponse['id_token'];

        $callbackURL = route('bkash.callback', ['invoiceId' => $invoice->id]);
        $paymentResponse = $this->bkash->createPayment($token, $invoice->id, $invoice->amount, $callbackURL);

        if (isset($paymentResponse['bkashURL'])) {
            // Redirect customer to bKash sandbox payment page
            return redirect($paymentResponse['bkashURL']);
        }

        return back()->with('error', 'Failed to initiate bKash payment.');
    }

    // Callback from bKash
    public function callback(Request $request, $invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        $tokenResponse = $this->bkash->getToken();
        $token = $tokenResponse['id_token'];

        $paymentID = $request->paymentID;
        $executeResponse = $this->bkash->executePayment($token, $paymentID);

        if (isset($executeResponse['transactionStatus']) && $executeResponse['transactionStatus'] === 'Completed') {
            $invoice->status = 'paid';
            $invoice->save();

            return redirect()->route('invoice.show', $invoice->id)
                ->with('success', 'bKash Payment Successful!');
        }

        return redirect()->route('invoice.show', $invoice->id)
            ->with('error', 'bKash Payment Failed!');
    }
}