
@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2 class="text-danger">❌ Payment Failed or Canceled</h2>
    <p>Your payment could not be processed. Please try again.</p>

    <a href="{{ route('checkout') }}" class="btn btn-warning mt-3">Retry Payment</a>
</div>
@endsection

