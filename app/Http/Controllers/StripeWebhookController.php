<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Stripe;
use App\Models\Order;
use App\Models\Payment;

class StripeWebhookController extends Controller {
    public function handle(Request $request) {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET'); // set this from Stripe dashboard if using webhooks

        try {
            if ($endpointSecret) {
                $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
            } else {
                $event = json_decode($payload);
            }
        } catch(\Exception $e) {
            return response('Invalid payload', 400);
        }

        $type = $event->type ?? ($event->type ?? null);

        // handle payment_intent.succeeded
        if (($event->type ?? '') === 'payment_intent.succeeded' || ($event->type ?? '') === 'checkout.session.completed') {
            $pi = $event->data->object;
            $payment_intent_id = $pi->id;
            $orderId = $pi->metadata->order_id ?? null;

            if ($orderId) {
                $order = Order::find($orderId);
                if ($order) {
                    $order->status = 'paid';
                    $order->save();

                    Payment::create([
                        'order_id' => $order->id,
                        'stripe_payment_intent_id' => $payment_intent_id,
                        'status' => 'succeeded',
                        'amount' => $pi->amount ?? $order->amount,
                        'currency' => $pi->currency ?? $order->currency,
                        'raw_response' => (array)$pi,
                    ]);
                }
            }
        }

        return response('Received', 200);
    }
}