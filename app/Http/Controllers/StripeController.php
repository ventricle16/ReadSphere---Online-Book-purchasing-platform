<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\PaymentIntent;
use Stripe\Webhook;

class StripeController extends Controller
{
    public function redirectToStripe(Order $order)
    {
        // Only allow owner to pay
        abort_if($order->user_id !== Auth::id(), 403, 'Unauthorized');
        abort_if($order->status !== 'pending', 400, 'Order not payable');

        Stripe::setApiKey(config('services.stripe.secret'));

        // Use a single line item with your grand total (already includes tax)
        $amountCents = (int) round($order->total_amount * 100);


        $session = CheckoutSession::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => "Readsphere Order #{$order->id}",
                        'description' => $order->product_name,
                    ],
                    'unit_amount' => $amountCents,
                ],
                'quantity' => 1,
            ]],
            'customer_email' => Auth::user()->email,
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('stripe.cancel', ['order' => $order->id]),
            'metadata'    => ['order_id' => $order->id],
            'automatic_tax' => ['enabled' => false], // you already added tax in total
        ]);

        // optional: save session id in payments table
        Payment::updateOrCreate(
            ['order_id' => $order->id],
            ['total_amount' => $order->calculateTotalAmount(), 'status' => 'pending', 'payment_method' => 'card', 'provider_ref' => $session->id]
        );

        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        $orderId   = $request->query('order');

        // Handle CheckoutSession flow (redirectToStripe method)
        if ($sessionId) {
            Stripe::setApiKey(config('services.stripe.secret'));
            $session = CheckoutSession::retrieve($sessionId);

            // Double-check payment
            $paid = $session->payment_status === 'paid' || $session->status === 'complete';
            $orderId = (int) ($session->metadata['order_id'] ?? 0);
            $order   = Order::findOrFail($orderId);

            abort_if($order->user_id !== Auth::id(), 403);

            if ($paid) {
                $order->update(['status' => 'paid']);

                Payment::where('order_id', $order->id)->update([
                    'status'       => 'paid',
                    'provider_ref' => $session->id
                ]);

                // ✅ Recalculate the final amount from cart (so UI matches checkout)
                $cart = $order->user->getCart();
                $cart?->refreshTotals();
                $finalAmount = $cart?->final_total ?? $order->calculateTotalAmount();

                // clear cart
                $cart?->items()->delete();

                return view('stripe.success', compact('order', 'finalAmount'));
            }

            return redirect()->route('stripe.cancel', ['order' => $order->id])
                ->with('error', 'Payment not completed.');
        }

        // Handle PaymentIntent flow (showStripePaymentForm method)
        if ($orderId) {
            $order = Order::findOrFail($orderId);
            abort_if($order->user_id !== Auth::id(), 403);

            $order->update(['status' => 'paid']);
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                ['total_amount' => $order->calculateTotalAmount(), 'status' => 'paid', 'payment_method' => 'card']
            );

            // ✅ Same final amount logic here too
            $cart = $order->user->getCart();
            $cart?->refreshTotals();
            $finalAmount = $cart?->final_total ?? $order->calculateTotalAmount();

            // clear cart
            $cart?->items()->delete();

            return view('stripe.success', compact('order', 'finalAmount'));
        }

        return redirect()->route('checkout')->with('error', 'Missing payment information.');
    }


    public function cancel(Request $request)
    {
        $orderId = (int) $request->query('order', 0);
        if ($orderId) {
            $order = Order::find($orderId);
            if ($order && $order->status === 'pending') {
                // keep pending; or mark failed if you prefer:
                // $order->update(['status' => 'failed']);
            }
        }
        return view('stripe.cancel', compact('orderId'));
    }

    // OPTIONAL: secure server-side confirmation
    public function webhook(Request $request)
    {
        $secret = config('services.stripe.webhook_secret', env('STRIPE_WEBHOOK_SECRET'));
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Throwable $e) {
            return response('Invalid', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $orderId = (int) ($session->metadata->order_id ?? 0);
            if ($orderId) {
                $order = Order::find($orderId);
                if ($order && $order->status !== 'paid') {
                    $order->update(['status' => 'paid']);
                    Payment::where('order_id',$orderId)->update([
                        'status' => 'paid',
                        'provider_ref' => $session->id
                    ]);
                }
            }
        }

        return response('OK', 200);
    }

    // New method to show the stripe payment form
    public function showStripePaymentForm(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403, 'Unauthorized');
        abort_if($order->status !== 'pending', 400, 'Order not payable');

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        // ✅ Recalculate from user's cart
        $cart = $order->user->getCart();
        $cart->refreshTotals();
        $finalAmount = $cart->final_total; // includes discount + tax

        if ($finalAmount <= 0) {
            return redirect()->route('checkout')->with('error', 'Invalid payment amount.');
        }

        $amountCents = (int) round($finalAmount * 100);

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amountCents,
            'currency' => 'usd',
            'metadata' => [
                'order_id' => $order->id,
            ],
        ]);

        $clientSecret = $paymentIntent->client_secret;

        return view('stripe', compact('order', 'clientSecret'))
            ->with('finalAmount', $finalAmount); // pass for blade UI too
    }

}


