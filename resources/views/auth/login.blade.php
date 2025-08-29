@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 50px auto; border: 1px solid #ddd; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px #ccc;">
    <h2 style="text-align: center; margin-bottom: 20px;">Readsphere</h2>
    <p style="text-align: center; margin-bottom: 20px;">Sign in to start your session</p>

    @if(session('error'))
        <div style="color: red; margin-bottom: 10px;">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div style="margin-bottom: 15px;">
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" style="width: 100%; padding: 10px; box-sizing: border-box;" required>
            @error('email')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <div style="margin-bottom: 15px;">
            <input type="password" name="password" placeholder="Password" style="width: 100%; padding: 10px; box-sizing: border-box;" required>
            @error('password')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" style="width: 100%; background-color: #007bff; color: white; padding: 10px; border: none; border-radius: 3px;">Login</button>
    </form>

    <p style="margin-top: 15px; text-align: center;">
        <a href="#" style="color: #007bff; text-decoration: none;">I forgot my password</a>
    </p>
</div>
@endsection
