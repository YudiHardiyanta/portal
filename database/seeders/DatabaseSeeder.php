<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\KonsepSeeder;
use Database\Seeders\KategoriSeeder;
use Database\Seeders\IndicatorSeeder;
use Database\Seeders\StandarDataSeeder;
use Database\Seeders\SubkategoriSeeder;
use Database\Seeders\ImprovementsTableSeeder;
use Database\Seeders\MetadataIndikatorSeeder;
use Database\Seeders\MetadataVariabelSeeder;

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

        $this->call([
            ImprovementsTableSeeder::class,
            UserSeeder::class,
            KategoriSeeder::class,
            SubkategoriSeeder::class,
            KonsepSeeder::class,
            StandarDataSeeder::class,
            MetadataVariabelSeeder::class,
            MetadataIndikatorSeeder::class,
            IndicatorSeeder::class,
        ]);
    }
}
