<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books - ReadSphere</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Books</h1>
        
        <div class="grid">
            @foreach($books as $book)
                <div class="card">
                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}">
                    <h2>{{ $book->title }}</h2>
                    <p>Author: {{ $book->author }}</p>
                    <p>Genre: {{ $book->genre }}</p>
                    <div class="card-actions">
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-primary">View Details</a>
                        <a href="{{ route('books.preview', $book->id) }}" class="btn btn-info">Preview</a>
                        <form action="{{ route('books.addToWishlist', $book->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary">Add to Wishlist</button>
                        </form>
                        
                    </div>
                </div>
            @endforeach
        </div>
        {{ $books->links() }} <!-- Pagination links -->
    </div>
</body>
</html>
