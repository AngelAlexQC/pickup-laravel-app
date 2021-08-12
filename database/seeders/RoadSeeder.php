<?php

namespace Database\Seeders;

use App\Models\Road;
use Illuminate\Database\Seeder;

class RoadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Road::factory()
            ->count(5)
            ->create();
    }
}
