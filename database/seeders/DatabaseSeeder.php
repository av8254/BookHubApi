<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\Collection;
use App\Models\Comment;
use App\Models\Following;
use App\Models\Rating;
use App\Models\User;
use Database\Factories\BookCollectionFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Book::factory(50)->create();
        Rating::factory(200)->create();
        Comment::factory(200)->create();
        Following::factory(10)->create();
        $collections = Collection::factory(20)->create();

        $collections->each(function ($collection) {
            $books = Book::factory(5)->create();
            $collection->books()->attach($books);
        });

        User::factory()->create([
            'first_name' => 'administrator',
            'last_name' => 'administrator',
            'email' => 'admin@mail.com',
            'password' => bcrypt('123456'),
        ]);



        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
