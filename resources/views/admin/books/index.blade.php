@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Manage Books</h5>
                    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">Add New Book</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Genre</th>
                                    <th>Price</th>
                                    <th>Rating</th>   <!-- ⭐ Added new column -->
                                    <th>Featured</th>
                                    <th>Active</th>
                                    <th>Wishlist Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $book)
                                    <tr>
                                        <td>
                                            @if($book->cover_url)
                                                <img src="{{ Storage::url($book->cover_url) }}" alt="{{ $book->title }}" style="width: 50px; height: 75px; object-fit: cover;">
                                            @else
                                                <div style="width: 50px; height: 75px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                                    <small>No Cover</small>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>{{ $book->genre }}</td>
                                        <td>${{ number_format($book->price, 2) }}</td>

                                        <!-- ⭐ Show rating -->
                                        <td>
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $book->rating)
                                                    ⭐
                                                @else
                                                    ☆
                                                @endif
                                            @endfor
                                        </td>

                                        <td>
                                            <span class="badge badge-{{ $book->is_featured ? 'success' : 'secondary' }}">
                                                {{ $book->is_featured ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $book->is_active ? 'success' : 'danger' }}">
                                                {{ $book->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
