<?php

namespace Database\Seeders;


use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'title' => 'First post',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'tags' => implode(', ', ['PHP', 'Laravel', 'Vue.js', 'Bootstrap']),
            'updated_at' => '14.09.2023',
            'created_at' => '14.09.2023'
        ]);
    }
}
