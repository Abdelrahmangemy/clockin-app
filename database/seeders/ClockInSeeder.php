<?php

namespace Database\Seeders;

use App\Models\ClockIn;
use Illuminate\Database\Seeder;

class ClockInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClockIn::factory()->count(10)->create();
    }
}
