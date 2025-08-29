<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories if they don't exist
        $categories = [
            'Fiction' => Category::firstOrCreate(['name' => 'Fiction']),
            'Non-Fiction' => Category::firstOrCreate(['name' => 'Non-Fiction']),
            'Self-Help' => Category::firstOrCreate(['name' => 'Self-Help']),
            'Technology' => Category::firstOrCreate(['name' => 'Technology']),
            'Business' => Category::firstOrCreate(['name' => 'Business']),
            'Romance' => Category::firstOrCreate(['name' => 'Romance']),
        ];

        $data = [
            [
                'title' => 'Factfulness',
                'author' => 'Hans Rosling',
                'cover_url' => 'https://images-na.ssl-images-amazon.com/images/I/81bPKd1rW8L.jpg',
                'category_id' => $categories['Non-Fiction']->id
            ],
            [
                'title' => 'The Other Son',
                'author' => 'Nick Alexander',
                'cover_url' => 'https://m.media-amazon.com/images/I/51yqvK0J3xL.jpg',
                'category_id' => $categories['Fiction']->id
            ],
            [
                'title' => 'Can You Keep a Secret?',
                'author' => 'Sophie Kinsella',
                'cover_url' => 'https://m.media-amazon.com/images/I/51VbQ7v3Z6L.jpg',
                'category_id' => $categories['Romance']->id
            ],
            [
                'title' => 'In the Company of Cheerful Ladies',
                'author' => 'Alexander McCall Smith',
                'cover_url' => 'https://m.media-amazon.com/images/I/51I9q8p8bqL.jpg',
                'category_id' => $categories['Fiction']->id
            ],
            [
                'title' => 'The Power of Agency',
                'author' => 'Paul Napper',
                'cover_url' => 'https://m.media-amazon.com/images/I/41Vd8cQ9cHL.jpg',
                'category_id' => $categories['Self-Help']->id
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'cover_url' => 'https://m.media-amazon.com/images/I/51-uspgqWIL.jpg',
                'category_id' => $categories['Self-Help']->id
            ],
            [
                'title' => 'Deep Work',
                'author' => 'Cal Newport',
                'cover_url' => 'https://m.media-amazon.com/images/I/41h5QLVwA-L.jpg',
                'category_id' => $categories['Self-Help']->id
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'cover_url' => 'https://m.media-amazon.com/images/I/41jEbK-jG+L.jpg',
                'category_id' => $categories['Technology']->id
            ],
        ];

        foreach ($data as $bookData) {
            Book::create($bookData);
        }
    }
}

