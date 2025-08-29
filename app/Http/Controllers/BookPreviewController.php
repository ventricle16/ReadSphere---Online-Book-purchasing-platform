<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookPreviewController extends Controller
{
    public function show(Book $book)
    {
        // Check if preview exists
        if (!$book->preview_file_path) {
            return view('books.preview', [
                'book' => $book,
                'error' => 'No preview file uploaded for this book.'
            ]);
        }

        if (!Storage::exists($book->preview_file_path)) {
            return view('books.preview', [
                'book' => $book,
                'error' => 'Preview file not found. Please contact support.'
            ]);
        }

        return view('books.preview', compact('book'));
    }

    public function getPage(Book $book, $page = 1)
    {
        if (!$book->preview_file_path || !Storage::exists($book->preview_file_path)) {
            return response()->json(['error' => 'Preview not available'], 404);
        }

        // Handle both public and private storage paths
        $filePath = storage_path('app/' . $book->preview_file_path);
        
        if (!file_exists($filePath)) {
            // Try alternative path
            $filePath = storage_path('app/public/' . $book->preview_file_path);
        }

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'Preview file not found'], 404);
        }

        return response()->file($filePath);
    }
}
