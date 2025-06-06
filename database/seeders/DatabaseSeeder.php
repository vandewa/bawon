<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(ComCodeSeeder::class);
        $this->call(LaratrustSeeder::class);
        $this->call([
            // DesaSeeder::class,
            // PaketPekerjaanSeeder::class,
            // VendorSeeder::class
        ]);
    }
}
