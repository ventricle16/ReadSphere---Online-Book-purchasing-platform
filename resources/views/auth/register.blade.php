@extends('layouts.app')

@section('content')
{{-- Full Screen Background --}}
<div class="fullscreen-background"
     style="background-image: url('{{ asset('images/bookstore-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;">
</div>

{{-- Centered Form --}}
<div class="d-flex align-items-center justify-content-center" style="height: 100vh; position: relative; z-index: 1;">
    <div class="card shadow-lg p-4 w-100" style="max-width: 450px; border-radius: 12px;">
        <div class="card-body">
            <h2 class="text-center mb-4 text-primary fw-bold">📚 Create Your Account</h2>
            <p class="text-center text-muted mb-4">Join <strong>ReadSphere</strong> and start exploring your favorite books today.</p>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Registration Form --}}
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="Enter your name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="Enter your email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Enter your password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="Confirm your password">
                </div>

                {{-- Submit Button --}}
                <div class="mb-3 d-grid">
                    <button type="submit" class="btn btn-primary fw-semibold">Register</button>
                </div>
            </form>

            {{-- Already Registered --}}
            <p class="text-center mt-3 mb-0">
                Already have an account?
                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-primary">Login here</a>
            </p>
        </div>
    </div>
</div>
@endsection
