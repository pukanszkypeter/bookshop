<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;
use App\Models\User;
use App\Models\Book;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // USERS (5 Reader - 5 Librarian)
        $this->call(UserSeeder::class);

        // BOOKS (20)
        $this->call(BookSeeder::class);

        // GENRES (10)
        $this->call(GenreSeeder::class);

        // BORROWS (5)
        $this->call(BorrowSeeder::class);

        // Associate genres to books
        $genres = Genre::all();
        $genres_count = $genres->count();

        Book::all()->each(function ($book) use (&$genres, &$genres_count) {
            $genre_ids = $genres->random(rand(1, $genres_count))->pluck('id')->toArray();
            $book->genres()->attach($genre_ids);
        });
    }
}
