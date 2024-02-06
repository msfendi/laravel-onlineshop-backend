<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::factory(4)->create();
        \App\Models\Category::factory()->create(
            [
                'name' => 'Man Clothes',
                'slug' => 'man-clothes',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias at quos accusantium repudiandae! Voluptatem sequi eveniet quia nihil, adipisci ullam.',
                'image' => 'https://via.placeholder.com/640x480.png/0055aa?text=et',
            ],
        );
    }
}
