<?php

namespace Database\Seeders;

use App\Models\LogAccess;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ShortLinkSeeder::class);
        $this->call(LogAccessSeeder::class);
    }
}
