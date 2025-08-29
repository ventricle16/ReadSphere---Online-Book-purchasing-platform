<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminBookController extends Controller
{
   public function __construct()
   {
       $this->middleware('admin');
   }
    public function index()
    {
        $books = Book::paginate(10); 
        return view('admin.books.index', compact('books'));
    }

   public function create()
   {
       return view('admin.books.create');
   }

   public function store(Request $request)
   {
       $validated = $request->validate([
           'title' => 'required|string|max:255',
           'author' => 'required|string|max:255',
           'genre' => 'required|string|max:100',
           'description' => 'required|string',
           'price' => 'required|numeric|min:0',
           'seo_tags' => 'nullable|string|max:500',
           'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
           'book_file' => 'required|mimes:pdf,epub|max:50000', // 50MB max
           'preview_file' => 'nullable|mimes:pdf,epub|max:5120', // 5MB max
           'preview_pages' => 'nullable|integer|min:1|max:10',
           'is_featured' => 'boolean',
           'is_active' => 'boolean',
           'rating' => 'nullable|integer|min:1|max:5' // ✅ make rating optional
       ]);

       // ✅ Default rating = 0 if not provided
       $validated['rating'] = $request->input('rating', 0);

       // Handle cover image upload
       if ($request->hasFile('cover')) {
           $coverPath = $request->file('cover')->store('book-covers', 'public');
           $validated['cover_url'] = Storage::url($coverPath);
       }

       // Handle book file upload
       if ($request->hasFile('book_file')) {
           $bookFile = $request->file('book_file');
           $filePath = $bookFile->store('books', 'public');
         
           $validated['file_path'] = $filePath;
           $validated['file_type'] = $bookFile->getClientOriginalExtension();
           $validated['file_size'] = $bookFile->getSize();
       }

       // Handle preview file upload
       if ($request->hasFile('preview_file')) {
           $previewFile = $request->file('preview_file');
           $previewPath = $previewFile->store('book-previews', 'public');
           $validated['preview_file_path'] = $previewPath;
       }

       $validated['preview_pages'] = $request->input('preview_pages', 2);

       // Create slug for SEO
       $validated['slug'] = Str::slug($validated['title']);

       Book::create($validated);

       return redirect()->route('admin.books.index')
           ->with('success', 'Book uploaded successfully!');
   }

   public function edit(Book $book)
   {
       return view('admin.books.edit', compact('book'));
   }

   public function update(Request $request, Book $book)
   {
       $validated = $request->validate([
           'title' => 'required|string|max:255',
           'author' => 'required|string|max:255',
           'genre' => 'required|string|max:100',
           'description' => 'required|string',
           'price' => 'required|numeric|min:0',
           'seo_tags' => 'nullable|string|max:500',
           'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
           'book_file' => 'nullable|mimes:pdf,epub|max:50000',
           'preview_file' => 'nullable|mimes:pdf,epub|max:5120',
           'preview_pages' => 'nullable|integer|min:1|max:10',
           'rating' => 'nullable|integer|min:1|max:5', // ✅ allow updating rating
           'is_featured' => 'boolean',
           'is_active' => 'boolean',
       ]);

       // ✅ Keep rating unchanged if not provided
       $validated['rating'] = $request->input('rating',1);

       // Handle cover image update
       if ($request->hasFile('cover')) {
           if ($book->cover_url) {
               $oldCoverPath = str_replace('/storage/', 'public/', $book->cover_url);
               Storage::delete($oldCoverPath);
           }
         
           $coverPath = $request->file('cover')->store('book-covers', 'public');
           $validated['cover_url'] = Storage::url($coverPath);
       }

       // Handle book file update
       if ($request->hasFile('book_file')) {
           if ($book->file_path) {
               Storage::delete($book->file_path);
           }
         
           $bookFile = $request->file('book_file');
           $filePath = $bookFile->store('books', 'public');
         
           $validated['file_path'] = $filePath;
           $validated['file_type'] = $bookFile->getClientOriginalExtension();
           $validated['file_size'] = $bookFile->getSize();
       }

       // Handle preview file update
       if ($request->hasFile('preview_file')) {
           if ($book->preview_file_path) {
               Storage::delete($book->preview_file_path);
           }
         
           $previewFile = $request->file('preview_file');
           $previewPath = $previewFile->store('book-previews', 'public');
           $validated['preview_file_path'] = $previewPath;
       }

       $validated['preview_pages'] = $request->input('preview_pages', 2);
       $validated['slug'] = Str::slug($validated['title']);

       $book->update($validated);

       return redirect()->route('admin.books.index')
           ->with('success', 'Book updated successfully!');
   }

   public function destroy(Book $book)
   {
       if ($book->cover_url) {
           $coverPath = str_replace('/storage/', 'public/', $book->cover_url);
           Storage::delete($coverPath);
       }

       if ($book->file_path) {
           Storage::delete($book->file_path);
       }

       $book->delete();

       return redirect()->route('admin.books.index')
           ->with('success', 'Book deleted successfully!');
   }

   public function download(Book $book)
   {
       if (!$book->file_path || !Storage::exists($book->file_path)) {
           abort(404, 'Book file not found');
       }

       return Storage::download($book->file_path, $book->title . '.' . $book->file_type);
   }
}
