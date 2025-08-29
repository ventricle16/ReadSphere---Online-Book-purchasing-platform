@extends('layouts.app')


@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4 sm:px-6 lg:px-8">
   <div class="max-w-6xl mx-auto">
       <!-- Header Section -->
       <div class="mb-8">
           <h1 class="text-3xl font-bold text-gray-900 mb-2">Upload New Book</h1>
           <p class="text-gray-600">Add a new book to your digital library collection</p>
       </div>


       <!-- Main Card -->
       <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
           <!-- Card Header -->
           <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
               <h2 class="text-xl font-semibold text-white">Book Information</h2>
           </div>


           <!-- Card Body -->
           <div class="p-6">
               <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                   @csrf


                   <!-- Basic Information Section -->
                   <div class="space-y-6">
                       <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Basic Information</h3>
                      
                       <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                           <!-- Title -->
                           <div>
                               <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Book Title *</label>
                               <input type="text" name="title" id="title"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('title') border-red-500 @enderror"
                                      value="{{ old('title') }}" required
                                      placeholder="Enter book title">
                               @error('title')
                                   <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>


                           <!-- Author -->
                           <div>
                               <label for="author" class="block text-sm font-medium text-gray-700 mb-2">Author Name *</label>
                               <input type="text" name="author" id="author"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('author') border-red-500 @enderror"
                                      value="{{ old('author') }}" required
                                      placeholder="Enter author name">
                               @error('author')
                                   <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>
                       </div>


                       <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                           <!-- Genre -->
                           <div>
                               <label for="genre" class="block text-sm font-medium text-gray-700 mb-2">Genre *</label>
                               <input type="text" name="genre" id="genre"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('genre') border-red-500 @enderror"
                                      value="{{ old('genre') }}" required
                                      placeholder="Enter genre">
                               @error('genre')
                                   <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>


                           <!-- Price -->
                           <div>
                               <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                               <input type="number" step="0.01" name="price" id="price"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('price') border-red-500 @enderror"
                                      value="{{ old('price') }}" required
                                      placeholder="0.00">
                               @error('price')
                                   <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>
                       </div>


                       <!-- Description -->
                       <div>
                           <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                           <textarea name="description" id="description" rows="4"
                                     class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('description') border-red-500 @enderror"
                                     required
                                     placeholder="Enter book description">{{ old('description') }}</textarea>
                           @error('description')
                               <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                           @enderror
                       </div>


                       <!-- SEO Tags -->
                       <div>
                           <label for="seo_tags" class="block text-sm font-medium text-gray-700 mb-2">SEO Tags</label>
                           <input type="text" name="seo_tags" id="seo_tags"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('seo_tags') border-red-500 @enderror"
                                  value="{{ old('seo_tags') }}"
                                  placeholder="fiction, fantasy, adventure (comma separated)">
                           <p class="mt-2 text-sm text-gray-500">These tags will help with search engine optimization</p>
                           @error('seo_tags')
                               <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                           @enderror
                       </div>


                       <!-- Rating -->
                       <div>
                           <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Rating (1–5 Stars)</label>
                           <select name="rating" id="rating"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('rating') border-red-500 @enderror">
                               <option value="1">1 Star</option>
                               <option value="2">2 Stars</option>
                               <option value="3">3 Stars</option>
                               <option value="4">4 Stars</option>
                               <option value="5">5 Stars</option>
                           </select>
                           @error('rating')
                               <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                           @enderror
                       </div>
                   </div>


                   <!-- File Uploads Section -->
                   <div class="space-y-6">
                       <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">File Uploads</h3>
                      
                       <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                           <!-- Cover Image -->
                           <div>
                               <label for="cover" class="block text-sm font-medium text-gray-700 mb-2">Cover Image *</label>
                               <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors duration-200">
                                   <input type="file" name="cover" id="cover"
                                          class="absolute inset-0 w-full h-full opacity-0 cursor-pointer @error('cover') border-red-500 @enderror"
                                          accept="image/*" required>
                                   <div class="pointer-events-none">
                                       <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 极 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2极12a2 2 0 002 2z" />
                                       </svg>
                                       <p class="mt-1 text-sm text-gray-600">Click to upload cover image</p>
                                       <p class="text-xs text-gray-500">JPEG, PNG, JPG up to 2MB</p>
                                   </div>
                               </div>
                               @error('cover')
                                   <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>


                           <!-- Book File -->
                           <div>
                               <label for="book_file" class="block text-sm font-medium text-gray-700 mb-2">Book File (PDF/ePub) *</label>
                               <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors duration-200">
                                   <input type="file" name="book_file" id="book_file"
                                          class="absolute inset-0 w-full h-full opacity-0 cursor-pointer @error('book_file') border-red-500 @enderror"
                                          accept=".pdf,.epub" required>
                                   <div class="pointer-events-none">
                                       <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                       </svg>
                                       <p class="mt-1 text-sm text-gray-600">Click to upload book file</p>
                                       <p class="text-xs text-gray-500">PDF, ePub up to 50MB</p>
                                   </div>
                               </div>
                               @error('book_file')
                                   <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>
                       </div>


                       <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                           <!-- Preview File -->
                           <div>
                               <label for="preview_file" class="block text-sm font-medium text-gray-700 mb-2">Preview File (PDF/ePub)</label>
                               <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors duration-200">
                                   <input type="file" name="preview_file" id="preview_file"
                                          class="absolute inset-0 w-full h-full opacity-0 cursor-pointer @error('极review_file') border-red-500 @enderror"
                                          accept=".pdf,.epub">
                                   <div class="pointer-events-none">
                                       <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                       </svg>
                                       <p class="mt-1 text-sm text-gray-600">Click to upload preview</p>
                                       <p class="text-xs text-gray-500">First 1-2 pages, up to 5MB</p>
                                   </div>
                               </div>
                               @error('preview_file')
                                   <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>


                           <!-- Preview Pages -->
                           <div>
                               <label for="preview_pages" class="block text-sm font-medium text-gray-700 mb-2">Preview Pages</label>
                               <input type="number" name="preview_pages" id="preview_pages"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('preview_pages') border-red-500 @enderror"
                                      value="{{ old('preview_pages', 2) }}"
                                      min="1" max="10"
                                      placeholder="Number of preview pages">
                               <p class="mt-2 text-sm text-gray-500">Number of pages to show in preview</p>
                               @error('preview_pages')
                                   <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>
                       </div>
                   </div>


                   <!-- Settings Section -->
                   <div class="space-y-6">
                       <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Settings</h3>
                      
                       <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                           <!-- Featured Book -->
                           <div>
                               <label class="flex items-center space-x-3">
                                   <input type="checkbox" name="is_featured" value="1"
                                          class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 @error('is_featured') border-red-500 @enderror"
                                          {{ old('is_featured') ? 'checked' : '' }}>
                                   <span class="text-sm font-medium text-gray-700">Featured Book</span>
                               </label>
                               @error('is_featured')
                                   <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>


                           <!-- Active Status -->
                           <div>
                               <label class="flex items-center space-x-3">
                                   <input type="checkbox" name极="is_active" value="1"
                                          class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 @error('is_active') border-red-500 @enderror"
                                          {{ old('is_active', true) ? 'checked' : '' }}>
                                   <span class="text-sm font-medium text-gray-700">Active</span>
                               </label>
                               @error('is_active')
                                   <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>
                       </div>
                   </div>


                   <!-- Submit Buttons -->
                   <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                       <a href="{{ route('admin.books.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">
                           Cancel
                       </a>
                       <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-800 transition-all duration-200 shadow-md hover:shadow-lg">
                           📚 Upload Book
                       </button>
                   </div>
               </form>
           </div>
       </div>
   </div>
</div>
@endsection
