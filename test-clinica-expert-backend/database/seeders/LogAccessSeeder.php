<?php

namespace Database\Seeders;

use App\Models\LogAccess;
use Illuminate\Database\Seeder;

class LogAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LogAccess::factory()
            ->count(50)
            ->create();
    }
}
