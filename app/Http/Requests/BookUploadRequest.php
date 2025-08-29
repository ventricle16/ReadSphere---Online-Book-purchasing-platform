<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


class BookUploadRequest extends FormRequest
{
   public function authorize(): bool
   {
       return auth()->check() && auth()->user()->role === 'admin';
   }


   public function rules(): array
   {
       return [
           'title' => 'required|string|max:255',
           'author' => 'required|string|max:255',
           'genre' => 'required|string|max:100',
           'description' => 'required|string|min:10',
           'price' => 'required|numeric|min:0|max:9999.99',
           'seo_tags' => 'nullable|string|max:500',
           'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
           'book_file' => 'required|mimes:pdf,epub|max:50000',
           'is_featured' => 'boolean',
           'is_active' => 'boolean',
       ];
   }


   public function messages(): array
   {
       return [
           'title.required' => 'The book title is required.',
           'author.required' => 'The author name is required.',
           'genre.required' => 'Please select a genre for the book.',
           'description.required' => 'A description is required.',
           'description.min' => 'Description must be at least 10 characters.',
           'price.required' => 'Please set a price for the book.',
           'price.numeric' => 'Price must be a valid number.',
           'cover.required' => 'A cover image is required.',
           'cover.image' => 'Cover must be an image file.',
           'book_file.required' => 'Please upload the book file (PDF or ePub).',
           'book_file.mimes' => 'Only PDF and ePub files are allowed.',
           'book_file.max' => 'Book file size must not exceed 50MB.',
       ];
   }
}
