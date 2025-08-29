@extends('layouts.app')


@section('content')
<div class="container-fluid">
   <div class="row">
       <div class="col-12">
           <div class="card">
               <div class="card-header">
                   <h3 class="card-title">Edit Book: {{ $book->title }}</h3>
               </div>
               <div class="card-body">
                   <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
                       @csrf
                       @method('PUT')
                      
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="title">Book Title *</label>
                                   <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                          value="{{ old('title', $book->title) }}" required>
                                   @error('title')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                   @enderror
                               </div>
                           </div>
                          
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="author">Author Name *</label>
                                   <input type="text" name="author" class="form-control @error('author') is-invalid @enderror"
                                          value="{{ old('author', $book->author) }}" required>
                                   @error('author')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                   @enderror
                               </div>
                           </div>
                       </div>


                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="genre">Genre *</label>
                                   <input type="text" name="genre" class="form-control @error('genre') is-invalid @enderror"
                                          value="{{ old('genre', $book->genre) }}" required>
                                   @error('genre')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                   @enderror
                               </div>
                           </div>
                          
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="price">Price *</label>
                                   <input type="number" step="0.01" name="price"
                                          class="form-control @error('price') is-invalid @enderror"
                                          value="{{ old('price', $book->price) }}" required>
                                   @error('price')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                   @enderror
                               </div>
                           </div>
                       </div>


                       <div class="form-group">
                           <label for="description">Description *</label>
                           <textarea name="description" rows="4"
                                     class="form-control @error('description') is-invalid @enderror"
                                     required>{{ old('description', $book->description) }}</textarea>
                           @error('description')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>


                       <div class="form-group">
                           <label for="seo_tags">SEO Tags</label>
                           <input type="text" name="seo_tags"
                                  class="form-control @error('seo_tags') is-invalid @enderror"
                                  value="{{ old('seo_tags', $book->seo_tags) }}"
                                  placeholder="Enter keywords separated by commas">
                           <small class="form-text text-muted">
                               These tags will help with search engine optimization
                           </small>
                           @error('seo_tags')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>


                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="cover">Cover Image</label>
                                   <input type="file" name="cover"
                                          class="form-control @error('cover') is-invalid @enderror"
                                          accept="image/*">
                                   <small class="form-text text-muted">
                                       Leave empty to keep current cover. Max size: 2MB
                                   </small>
                                   @error('cover')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                   @enderror
                                  
                                   @if($book->cover_url)
                                       <div class="mt-2">
                                           <img src="{{ $book->cover_url }}" alt="Current cover"
                                                style="max-width: 100px; max-height: 150px;">
                                           <p class="text-muted small">Current cover</p>
                                       </div>
                                   @endif
                               </div>
                           </div>
                          
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="book_file">Book File (PDF/ePub)</label>
                                   <input type="file" name="book_file"
                                          class="form-control @error('book_file') is-invalid @enderror"
                                          accept=".pdf,.epub">
                                   <small class="form-text text-muted">
                                       Leave empty to keep current file. Max size: 50MB
                                   </small>
                                   @error('book_file')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                   @enderror
                                  
                                   @if($book->file_path)
                                       <div class="mt-2">
                                           <p class="text-muted small">
                                               Current file: {{ $book->title }}.{{ $book->file_type }}
                                               ({{ $book->file_size_human_readable }})
                                           </p>
                                       </div>
                                   @endif
                               </div>
                           </div>
                       </div>


                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                   <div class="form-check">
                                       <input type="checkbox" name="is_featured" value="1"
                                              class="form-check-input"
                                              {{ old('is_featured', $book->is_featured) ? 'checked' : '' }}>
                                       <label class="form-check-label" for="is_featured">
                                           Featured Book
                                       </label>
                                   </div>
                               </div>
                           </div>
                          
                           <div class="col-md-6">
                               <div class="form-group">
                                   <div class="form-check">
                                       <input type="checkbox" name="is_active" value="1"
                                              class="form-check-input"
                                              {{ old('is_active', $book->is_active) ? 'checked' : '' }}>
                                       <label class="form-check-label" for="is_active">
                                           Active
                                       </label>
                                   </div>
                               </div>
                           </div>
                       </div>


                       <div class="form-group">
                           <button type="submit" class="btn btn-primary">
                               <i class="fas fa-save"></i> Update Book
                           </button>
                           <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                               Cancel
                           </a>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
