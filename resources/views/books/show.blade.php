<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $book->title }} - ReadSphere</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .book-details {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .book-header {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }
        .book-cover {
            flex: 0 0 300px;
        }
        .book-cover img {
            width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .book-info {
            flex: 1;
        }
        .book-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #1f2937;
        }
        .book-author {
            font-size: 1.2rem;
            color: #6b7280;
            margin-bottom: 20px;
        }
        .book-meta {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 25px;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
        }
        .meta-label {
            font-weight: 600;
            color: #374151;
            min-width: 80px;
        }
        .price {
            font-weight: 700;
            color: #22c55e;
            font-size: 1.4rem;
        }
        .rating {
            color: #f59e0b;
            font-size: 1.2rem;
        }
        .card-actions {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, #007AFF 0%, #0056CC 100%);
            color: white;
            border: none;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 122, 255, 0.3);
        }
        .related-books {
            margin-top: 50px;
        }
        .related-books h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #1f2937;
        }
        .card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            padding: 15px;
        }
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .card-text {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 12px;
        }
        .btn-sm {
            padding: 8px 16px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="book-details">
        <div class="book-header">
            <div class="book-cover">
                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}">
            </div>
            <div class="book-info">
                <h1 class="book-title">{{ $book->title }}</h1>
                <p class="book-author">by {{ $book->author }}</p>
                
                <div class="book-meta">
                    <div class="meta-item">
                        <span class="meta-label">Genre:</span>
                        <span>{{ $book->genre }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Price:</span>
                        <span class="price">${{ number_format($book->price, 2) }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Rating:</span>
                        <span class="rating">
                            @if($book->rating)
                                ⭐ {{ $book->rating }}/5
                            @else
                                ⭐ N/A
                            @endif
                        </span>
                    </div>
                    @if($book->category)
                    <div class="meta-item">
                        <span class="meta-label">Category:</span>
                        <span>{{ $book->category->name }}</span>
                    </div>
                    @endif
                </div>

                @if($book->description)
                <div class="book-description">
                    <h3>Description</h3>
                    <p>{{ $book->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="card-actions">
            <a href="{{ route('books.index') }}" class="btn btn-primary">Back to Books</a>
        </div>

        <!-- Related Books Section -->
        @if(isset($relatedBooks) && $relatedBooks->count() > 0)
        <div class="related-books">
            <h2>Related Books</h2>
            <div class="row">
                @foreach($relatedBooks as $relatedBook)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="{{ $relatedBook->cover_url }}" class="card-img-top" alt="{{ $relatedBook->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $relatedBook->title }}</h5>
                            <p class="card-text">Author: {{ $relatedBook->author }}</p>
                            <p class="card-text">
                                <span class="price" style="font-size: 1rem;">${{ number_format($relatedBook->price, 2) }}</span>
                                <span class="rating" style="font-size: 0.9rem;">⭐ {{ $relatedBook->rating ?? 'N/A' }}</span>
                            </p>
                            <a href="{{ route('books.show', $relatedBook->id) }}" class="btn btn-sm btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</body>
</html>
