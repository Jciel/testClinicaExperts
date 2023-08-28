<?php

namespace Database\Seeders;

use App\Models\ShortLink;
use Illuminate\Database\Seeder;

class ShortLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShortLink::factory()
            ->count(20)
            ->create();
    }
}
