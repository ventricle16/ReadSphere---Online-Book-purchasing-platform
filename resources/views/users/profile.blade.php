@extends('layouts.app')

@section('content')
<h1>{{ $user->name }}</h1>
<p>{{ $user->bio }}</p>
<form method="POST" action="{{ $user->id ? route('users.update', $user->id) : '#' }}">
    @csrf
    @method('PUT')
    <input type="text" name="name" placeholder="Name" value="{{ $user->name }}">
    <textarea name="bio" placeholder="Bio">{{ $user->bio }}</textarea>
    <button type="submit">Update</button>
</form>
@endsection
