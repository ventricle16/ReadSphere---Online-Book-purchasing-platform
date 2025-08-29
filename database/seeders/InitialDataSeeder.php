<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // Insert sample user if not exists
        $user = DB::table('users')->where('email', 'nuhan1997@gmail.com')->first();
        if (!$user) {
            DB::table('users')->insert([
                'name' => 'Nuhan Habib',
                'email' => 'nuhan1997@gmail.com',
                'profile_picture' => 'url_to_profile_pic.jpg',
                'bio' => 'A passionate reader always exploring new worlds through books.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Insert sample book
        $book = DB::table('books')->where('title', 'Introduction to Software Engineering')->first();
        if (!$book) {
            DB::table('books')->insert([
                'title' => 'Introduction to Software Engineering',
                'author' => 'Ronald J. Leach',
                'price' => 25.99,
                'description' => 'Introduction to Software Engineering, Second Edition equips...',
                'cover_url' => 'url_to_book_cover.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}