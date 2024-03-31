<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Post::factory()->create([
            'title' => 'First Post',
            'context' => 'Hello World',
            'slug' => 'first-post',
            'user_id' => 1,
            'media_id' => null
        ]);
        $categories = \App\Models\Category::all();

        // Populate the pivot table
        \App\Models\Post::all()->each(function ($post) use ($categories) { 
            $post->categories()->attach(
                $categories->random(rand(1, 1))->pluck('id')->toArray()
            ); 
        });

        $tags = \App\Models\Tag::all();

        // Populate the pivot table
        \App\Models\Post::all()->each(function ($post) use ($tags) { 
            $post->tags()->attach(
                $tags->random(rand(1, 1))->pluck('id')->toArray()
            ); 
        });
    }
}
