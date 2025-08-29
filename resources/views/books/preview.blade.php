@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Book Preview: {{ $book->title }}</h3>
                    <div>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Book
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="book-preview-container">
                        <div class="preview-header text-center mb-4">
                            <h4>{{ $book->title }}</h4>
                            <p class="text-muted">by {{ $book->author }}</p>
                            
                            @if(isset($error))
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    {{ $error }}
                                </div>
                            @elseif($book->preview_pages)
                                <p class="text-info">
                                    <i class="fas fa-info-circle"></i> 
                                    Showing preview of {{ $book->preview_pages }} pages
                                </p>
                            @endif
                        </div>

                        @if(!isset($error))
                        <div class="book-preview-reader">
                            <div class="page-container">
                                <div class="page" id="page-1">
                                    <div class="page-content">
                                        <iframe src="{{ route('books.preview.page', [$book, 1]) }}"
                                                width="100%"
                                                height="600px"
                                                style="border: none;"
                                                onerror="this.style.display='none'; document.getElementById('preview-error').style.display='block';">
                                        </iframe>
                                        <div id="preview-error" style="display: none;" class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Preview file could not be loaded. Please try again later.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                            
                            <div class="preview-controls text-center mt-4">
                                <button class="btn btn-outline-primary" onclick="window.print()">
                                    <i class="fas fa-print"></i> Print Preview
                                </button>
                                <a href="{{ route('books.show', $book->id) }}" class="btn btn-success">
                                    <i class="fas fa-shopping-cart"></i> Buy Full Book
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.book-preview-reader {
    max-width: 800px;
    margin: 0 auto;
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.page-container {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.page-content {
    padding: 20px;
}

.preview-controls {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .book-preview-reader {
        padding: 10px;
    }
    
    .page-content {
        padding: 10px;
    }
    
    .preview-controls {
        flex-direction: column;
        align-items: center;
    }
}
</style>
@endsection
