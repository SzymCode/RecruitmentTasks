<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Szymon Radomski',
            'email' => 'business@szymco.de',
            'role' => 'admin',
            'password' => Hash::make('admin123')
        ]);
    }
}
