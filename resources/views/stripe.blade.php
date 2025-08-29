@extends('layouts.app')


@section('content')
<div class="container">
    <h3>Pay Securely</h3>
    <p class="text-muted">Complete your payment with your card.</p>


    <div class="row">
        <!-- Payment Form -->
        <div class="col-md-7">
            <form id="payment-form">
                @csrf
                <div id="payment-element" class="form-control mb-3"></div>
                <button id="submit" class="btn btn-success w-100">
                    <span id="button-text">
                        Pay ${{ number_format($finalAmount, 2) }}
                    </span>
                </button>
                <div id="error-message" class="text-danger mt-2"></div>
            </form>
        </div>


        <!-- Order Summary -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Order #{{ $order->id }}</div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Mobile:</strong> {{ $order->customer_mobile }}</p>
                    <p><strong>Total:</strong>
                        ${{ number_format($finalAmount, 2) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");


    // ✅ this comes from controller: StripeController@showStripePaymentForm
    const options = {
        clientSecret: "{{ $clientSecret }}",
        appearance: { theme: 'stripe' } // optional styling
    };


    const elements = stripe.elements(options);
    const paymentElement = elements.create("payment");
    paymentElement.mount("#payment-element");


    const form = document.getElementById("payment-form");
    const submitButton = document.getElementById("submit");
    const buttonText = document.getElementById("button-text");


    form.addEventListener("submit", async (e) => {
        e.preventDefault();


        // Disable button to avoid double click
        submitButton.disabled = true;
        buttonText.textContent = "Processing...";


        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                // ✅ redirect after successful payment
                return_url: "{{ route('stripe.success') }}?order={{ $order->id }}",
            },
        });


        if (error) {
            document.getElementById("error-message").textContent = error.message;
            submitButton.disabled = false;
            buttonText.textContent = "Pay ${{ number_format($order->total_amount ?? $order->calculateTotalAmount(), 2) }}";
        }
    });
</script>
@endsection

