<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call([
            
        //     UserSeeder::class,
        // ]);
        User::factory()->create([
            'name' => 'Company Admin',
            'email' => 'admin@gmail.com',
            'contactno' => '9874563210',
        ]);
    }
}
