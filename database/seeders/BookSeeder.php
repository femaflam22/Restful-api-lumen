<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use Carbon\Carbon;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::insert([
            [
                'title' => 'Laut Bercerita',
                'author' => 'Leila Salikha Chudori',
                'publisher' => 'Gramedia Jakarta',
                'cover' => 'laut.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Hujan Bulan Juni',
                'author' => 'Sapardi Djoko Damono',
                'publisher' => 'Grasindo',
                'cover' => 'hujan.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Nebula',
                'author' => 'Tere Liye',
                'publisher' => 'Gramedia Pustaka Utama',
                'cover' => 'nebula.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'In a Blue Moon',
                'author' => 'Ilana Tan',
                'publisher' => 'Gramedia Pustaka Utama',
                'cover' => 'moon.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
